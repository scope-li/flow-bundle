# Retro: Upgrade scopeli/flow-bundle auf Symfony 7.4/8.x + PHP 8.3+

## Phase 1: Foundation (composer.json + Configs)

### Was wurde gemacht
- **composer.json komplett ueberarbeitet**
  - `php` von `>=7.4.5` auf `>=8.3`
  - Alle `symfony/*` Pakete von `^4.4|^5.0` auf `^7.4|^8.0`
  - `doctrine/orm` von `~2.4` auf `^2.19|^3.0`
  - `ramsey/uuid` von `^4.2` auf `^4.7|^5.0`
  - `phpstan/phpstan` von `^1.1` auf `^2.0`
  - `phpunit/phpunit` von `^9.5` auf `^11.0`
  - `ext-json` entfernt (seit PHP 8.0 immer eingebaut)
  - `symfony/event-dispatcher-contracts` ersetzt durch `symfony/event-dispatcher` (Contracts sind ab Sf7 integriert)
  - `friendsofphp/php-cs-fixer`, `rector/rector`, `squizlabs/php_codesniffer` entfernt
  - `allow-plugins` Config entfernt
  - Scripts aufgeraeumt: nur `phpstan`, `phpunit`, `test` behalten
- **rector.php geloescht** - nutzte die alte `Rector\Core\*` API die seit Rector 1.0 nicht mehr existiert, und Rector ist keine Dev-Dependency mehr
- **.php-cs-fixer.dist.php geloescht** - php-cs-fixer ist keine Dev-Dependency mehr
- **phpunit.xml modernisiert** - Schema auf PHPUnit 11 (`phpunit.xsd`), `<logging>` Block entfernt (deprecated), `<coverage>` in `<source>` umgewandelt (PHPUnit 11 Syntax)
- **composer install** erfolgreich ausgefuehrt mit den neuen Dependencies

### Warum
Die alten Versionsconstraints waren inkompatibel mit Symfony 7/8 und PHP 8.3. Rector und php-cs-fixer waren Tooling-Dependencies die fuer ein Bundle nicht noetig sind. Die phpunit.xml musste auf das PHPUnit 11 Schema umgestellt werden, da PHPUnit 11 die alte `<coverage>` und `<logging>` Syntax nicht mehr unterstuetzt.

---

## Phase 2: Bundle-Klasse + DI modernisieren

### Was wurde gemacht
- **ScopeliFlowBundle von `Bundle` auf `AbstractBundle` umgestellt** - Die neue Symfony-Methode erlaubt es, Configuration und Extension direkt in der Bundle-Klasse zu definieren via `configure()` und `loadExtension()`
- **Configuration.php Logik in `ScopeliFlowBundle::configure()` verschoben** - TreeBuilder-Definition direkt in der Bundle-Klasse
- **ScopeliFlowExtension.php Logik in `ScopeliFlowBundle::loadExtension()` verschoben** - Service-Import, Interface-Aliases und Autoconfiguration
- **DependencyInjection/ Ordner komplett geloescht** - Nicht mehr noetig mit AbstractBundle
- **Doppelte Service-ID in services.xml behoben** - `scopeli_flow.event_listener.logger` war sowohl fuer LoggerListener als auch OperationListener vergeben. OperationListener hat jetzt die eigene ID `scopeli_flow.event_listener.operation`

### Warum
`AbstractBundle` ist der empfohlene Weg ab Symfony 6.1+ und vereinfacht die Bundle-Struktur erheblich. Die separate Extension- und Configuration-Klasse im DependencyInjection-Ordner ist damit obsolet. Die doppelte Service-ID war ein Bug der dazu fuehren konnte, dass der LoggerListener vom OperationListener ueberschrieben wurde.

---

## Phase 3: Code-Generierung modernisieren

### Was wurde gemacht
- **Template `Class.tpl.php` modernisiert**
  - `declare(strict_types=1);` hinzugefuegt
  - Return-Type-Spacing von ` : ` auf `: ` korrigiert (PSR-12 konform)
- **Template `Bpmn.tpl.php` modernisiert**
  - `declare(strict_types=1);` hinzugefuegt
  - Leere Zeilen zwischen Methodensignatur und oeffnender Klammer entfernt
- **CreateClassCommand modernisiert**
  - `#[AsCommand]` Attribute statt `protected static $defaultName` (Symfony 7 Weg)
  - Typed Constants (`private const string XSD`, `private const string OUTPUT`, etc.)
  - `match` statt `switch` in `getReturnType()` - kompakterer, ausdruecksstarkerer Code
  - Constructor-Parameter `?string $name = null` entfernt (deprecated in Symfony 7)
  - PHPStan-konforme Type-Annotations hinzugefuegt
- **Alle ~150 Element-Klassen neu generiert** via `php bin/run create:class`
- **AbstractElement.php manuell modernisiert** - Constructor Promotion mit `private readonly`
- **ElementList.php manuell modernisiert** - `readonly` Property fuer `$elements`, typisierter Constructor-Parameter

### Warum
Die generierten Klassen machen ~80% des `src/Element/` Ordners aus. Anstatt jede einzeln zu editieren, wurden die Templates aktualisiert und der Command ausgefuehrt - so ist sichergestellt, dass alle generierten Dateien konsistent sind. `#[AsCommand]` ist der Standard in Symfony 7+ und `$defaultName` ist deprecated. Typed Constants sind ein PHP 8.3 Feature das den Code selbstdokumentierender macht.

---

## Phase 4: PHP 8.3+ Code-Modernisierung

### Was wurde gemacht
- **Constructor Promotion + readonly** in allen nicht-generierten Klassen:
  - `DoctrineListener`, `LoggerListener`, `OperationListener` - einfaches `private readonly`
  - `AbstractEvent` - `protected` (nicht readonly, da `$processInstance` mutiert werden kann via Subklassen)
  - `ProcessRunner` - `protected readonly` fuer geerbte Properties, `private readonly` fuer private; `$processInstance` bleibt mutable (wird auf null gesetzt)
  - `ConnectorRunner` - readonly array fuer validierte `$connectorInstances`
  - `ScriptRunner` - readonly array fuer validierte `$scripts`
- **Typed Constants (PHP 8.3)** in Event-Klassen:
  - `ActivityEvents`, `OperationEvents`, `ProcessInstanceEvents` - alle `public const` auf `public const string` umgestellt
  - Veraltete `@var string` und `@Event` Annotations entfernt
- **`declare(strict_types=1)`** zu allen 196+ PHP-Dateien hinzugefuegt (src/ und tests/)

### Warum
Constructor Promotion reduziert Boilerplate erheblich (Property-Deklaration, Parameter und Zuweisung in einer Zeile). `readonly` verhindert versehentliche Mutation und macht den Code robuster. Typed Constants sind PHP 8.3+ und machen die Typen explizit. `declare(strict_types=1)` erzwingt strikte Typ-Pruefungen und verhindert implizite Type-Coercions.

---

## Phase 5: Doctrine ORM Kompatibilitaet

### Was wurde gemacht
- **DoctrineListener Import geaendert**: `Doctrine\ORM\Event\LifecycleEventArgs` auf `Doctrine\Persistence\Event\LifecycleEventArgs`
- **`getEntity()` auf `getObject()` geaendert** - in allen Lifecycle-Event-Handlern
- **Generic-Type-Annotations** fuer `LifecycleEventArgs<\Doctrine\Persistence\ObjectManager>` hinzugefuegt (PHPStan Level 9)

### Warum
`Doctrine\ORM\Event\LifecycleEventArgs` wurde in Doctrine ORM 3.0 entfernt. Die Klasse aus `doctrine/persistence` ist der zukunftssichere Ersatz und funktioniert sowohl mit Doctrine ORM 2.19+ als auch 3.x. `getEntity()` ist ebenfalls deprecated zugunsten von `getObject()`.

---

## Phase 6: Tests modernisieren (PHPUnit 11)

### Was wurde gemacht
- **`@dataProvider` Annotations auf `#[DataProvider]` Attributes migriert** in:
  - `ElementTest` (2 Methoden)
  - `ScriptTwigTest` (1 Methode)
  - `ScriptRunnerTest` (1 Methode)
- **DataProvider-Methoden auf `static` umgestellt** - PHPUnit 11 erfordert statische DataProvider
- **Abstract Test Class aus Testsuite ausgeschlossen** - `AbstractSerializerTest.php` in phpunit.xml excludiert, da PHPUnit 11 eine Warning fuer abstrakte Klassen im Test-Directory wirft und `failOnWarning="true"` gesetzt ist

### Warum
PHPUnit 11 hat die `@dataProvider` Annotation deprecated zugunsten von PHP 8 Attributes. DataProvider muessen in PHPUnit 11 statisch sein. Die Warning fuer die abstrakte Testklasse haette mit `failOnWarning="true"` den CI-Build rot gemacht.

---

## Phase 7: Validation & Quality

### Was wurde gemacht
- **phpstan.neon aktualisiert**
  - `checkMissingIterableValueType: false` entfernt (existiert in PHPStan 2.x nicht mehr)
  - Stattdessen `missingType.iterableValue` in `ignoreErrors` aufgenommen (aequivalentes Verhalten)
  - Pfad zu `DependencyInjection/Configuration.php` aus `excludePaths` entfernt (Datei existiert nicht mehr)
- **PHPStan Level 9 Fehler behoben** (42 initiale Fehler auf 0 reduziert):
  - `nodeValue` Nullable-Casts (DOMElement.nodeValue ist `?string`)
  - `localName` Nullable-Cast in `AbstractElement::createElement()`
  - Unnoetige `instanceof DOMNamedNodeMap` Pruefung entfernt (DOMElement.attributes ist nie null)
  - Type-Assertions fuer Array-Offsets auf `$this->classes` im CreateClassCommand
  - PHPStan-konforme `@param` Annotations fuer `loadExtension()`, DoctrineListener etc.
- **Alle drei Validierungs-Checks bestehen:**
  - `composer validate --strict` - valid
  - `vendor/bin/phpstan analyse src --level 9` - 0 errors
  - `vendor/bin/phpunit` - 65 tests, 873 assertions, OK

### Warum
PHPStan 2.x hat einige Konfigurationsoptionen umbenannt oder entfernt. Die meisten PHPStan-Fehler kamen von strikteren Null-Safety-Checks in Level 9 (z.B. `DOMElement::$nodeValue` ist `?string` statt `string`). Diese wurden mit expliziten Casts und Assertions behoben - keine Fehler unterdrueckt ausser dem bereits vorher ignorierten `missingType.iterableValue`.

---

## Zusammenfassung

| Metrik | Vorher | Nachher |
|--------|--------|---------|
| PHP | >=7.4.5 | >=8.3 |
| Symfony | ^4.4/^5.0 | ^7.4/^8.0 |
| Doctrine ORM | ~2.4 | ^2.19/^3.0 |
| PHPUnit | ^9.5 | ^11.0 |
| PHPStan | ^1.1 | ^2.0 |
| Dev-Dependencies | 7 | 4 |
| PHP-Dateien mit strict_types | ~0 | alle |
| Constructor Promotion | 0 | alle relevanten Klassen |
| Typed Constants | 0 | alle Konstanten-Klassen |
| Tests | 65 pass | 65 pass |
| PHPStan Level 9 Errors | unbekannt | 0 |
