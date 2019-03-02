<?php
namespace WorkspaceJobRouter;

use WorkspaceJobRouter\Controller\WorkspaceRouterController;
use WorkspaceJobRouter\Factory\Controller\WorkspaceRouterControllerFactory;

return array(
    'router' => array(
        'routes' => array(
            'collect-jobs' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/test',
                    'defaults' => array(
                        'controller' => WorkspaceRouterController::class,
                        'action'     => 'test'
                    )
                )
            ),
        ),
    ),
    'controllers'  => [
        'factories' => [
            WorkspaceRouterController::class => WorkspaceRouterControllerFactory::class
        ]
    ],

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

);