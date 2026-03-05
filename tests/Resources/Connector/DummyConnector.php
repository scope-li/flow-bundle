<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle\Resources\Connector;

use Scopeli\FlowBundle\Connector\ConnectorInterface;
use Scopeli\FlowBundle\ProcessDataTrait;

class DummyConnector implements ConnectorInterface
{
    use ProcessDataTrait;

    public function run()
    {
        return $this->dataSet2;
    }
}
