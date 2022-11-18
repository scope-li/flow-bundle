<?php

namespace Scopeli\FlowBundle;

use Scopeli\FlowBundle\DependencyInjection\ScopeliFlowExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ScopeliFlowBundle extends Bundle
{
    public function getContainerExtension(): ScopeliFlowExtension
    {
        return new ScopeliFlowExtension();
    }
}
