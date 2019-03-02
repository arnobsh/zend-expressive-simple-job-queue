Zend Expressive Workspace Job Router
=====================================

------

Lightweight library for managing job queue on different workspaces

It is designed for [zend-expressive](https://github.com/zendframework/zend-expressive) 
applications, but it can work with any PHP project.
 
Usage
-----

### Config files

At the basic level, ConfigManager can be used to merge PHP-based configuration files: 

Add config file workspace.global.php at config/autoload/local

```php
<?php
/**
 * Created by PhpStorm.
 * User: arnobsh@gmail.com
 * Date: 2/1/2019
 * Time: 10:45 AM
 */

return [
    'workspace' => array( 'JobService1','JobService2','JobService3'),
];
```

It should return plain PHP array:


### App Handler

Create test handler and test handler factory to route the workspaces.
First create a TestWorkspaceHandlerFactory.php under the App\Handler

```php
<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use WorkspaceJobRouter\Service\WorkspaceRouterService;
use function get_class;

class TestWorkspaceHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $config     = $container->get('config');
        $workspaceConfig = $config['workspace'];
        $fileLocation =  "/var/www/data/deadletter";

        $workspaceRouter = new WorkspaceRouterService($fileLocation,$workspaceConfig);

        return new TestWorkspaceHandler(get_class($container), $router, $workspaceRouter);
    }
}
```

If provider is a class name, it is automatically instantiated. Create the Handler class by following

TestWorkspaceHandler.php
```php
<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class TestWorkspaceHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;
    private $workspaceRouter;

    public function __construct(
        string $containerName,
        Router\RouterInterface $router,
        $workspaceRouter
    ) {
        $this->containerName = $containerName;
        $this->router        = $router;
        $this->workspaceRouter = $workspaceRouter;
    }


    /**
     * API call for routing the workspace data
     * POST request call with body data
     * @route /route-workspaces
     * @param  $data workspace data need to be re-route
     * @format json format post data
     * [{
            "WorkspaceId": 1234,
            "WorkspaceName": "JobService1",
            "JobMetadata": {
            "JobItemId": 4567,
            "JobOrderId": 1267,
            "JobDetails": "test"
            }
        }]
     * @param $request request object
     * @return Jsonresponse with dequeued workspace
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            $params = $request->getParsedBody();
            $workspaceData = $params[0];
            $this->workspaceRouter->route($workspaceData);

            return new JsonResponse([
                'request'      => $params,
                'response'    => "Successfully Workspace Routed"
            ]);
        }
        catch (\Exception $e) {
            return new JsonResponse([
                'error' => true,
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

}

```

Also add App\ConfigProvider.php to facilitate the service through the router.

App\ConfigProvider.php

```php
<?php

declare(strict_types=1);

namespace App;

use App\Handler\TestWorkspaceHandler;
use App\Handler\TestWorkspaceHandlerFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                Handler\HomePageHandler::class              => Handler\HomePageHandlerFactory::class,
                //factories
                TestWorkspaceHandler::class          			=> TestWorkspaceHandlerFactory::class,
                
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}

```

### Routing

In order to route the handler and functions :

config\routes.php

```php
<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;


return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    
    $app->route('/route-workspaces', \App\Handler\TestWorkspaceHandler::class,['POST','GET','PUT','DELETE'], 'app.workspaceRouter');
    

};

```
