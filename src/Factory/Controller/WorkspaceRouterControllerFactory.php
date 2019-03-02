<?php

namespace WorkspaceJobRouter\Factory\Controller;

use WorkspaceJobRouter\Controller\WorkspaceRouterController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class WorkspaceRouterControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new WorkspaceRouterController();
    }


}