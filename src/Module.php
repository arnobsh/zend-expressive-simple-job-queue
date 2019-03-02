<?php

namespace WorkspaceJobRouter;


class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
            )
        );
    }
}