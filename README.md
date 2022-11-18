# Flow
Flow is a BPMN 2.0 workflow engine for Symfony.

[TOC]

## Supported elements
* Sequence flows
* Activities
  * Task
  * Service Task
  * Send Task
  * Receive Task
  * User Task
  * Manual Task
  * Script Task
* Gateway
  * Exclusive Gateway
  * Inclusive Gateway
  * Parallel Gateway
* Events
  * Start Event
  * MessageStart Event
  * End Event
  * TerminateEnd Event
  * Message Intermediate Catch Event
  * Message Boundary Event
  * Message Boundary Event (non-interrupting)

Also some feature and elements from Camunda BPMN's are supported.
* User Task
  * FormKey
  * Assignee
* Connector
* InputOutput
  * `Map` Parameter
  * `List` Parameter
  * `Script` Parameter
  * `String|Expression` Parameter

## Expression
For expressions you can use the [Symfony Expressions](https://symfony.com/doc/current/components/expression_language.html).

## Script
For elements that use script, [Twig](https://twig.symfony.com/) is supported out of the box.

# Installation
Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require scopeli/flow-bundle
```

## Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require scopeli/flow-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Scopeli\FlowBundle\ScopeliFlowBundle::class => ['all' => true],
];
```

```console
$ composer require scopeli/flow-bundle
```

## Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require scopeli/flow-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Scopeli\FlowBundle\ScopeliFlowBundle::class => ['all' => true],
];
```