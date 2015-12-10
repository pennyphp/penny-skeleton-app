<?php
use Penny\ExcpHandler\EventListener\WhoopsListener;

return [
    'event_manager' => \DI\decorate(function($eventManager, $container) {
        $eventManager->attach("dispatch_error", [$container->get(WhoopsListener::class), "onError"]);
        $eventManager->attach("*_error", [$container->get(WhoopsListener::class), "onError"]);
        
        // this is usage if we want to use templated error handler
//       \App\EventListener\ExceptionListener::class => \DI\object(\App\EventListener\ExceptionListener::class)
//                ->constructor(\DI\get("template")),
//       \App\EventListener\DispatcherExceptionListener::class => \DI\object(\App\EventListener\DispatcherExceptionListener::class)
//               ->constructor(\DI\get("template")),

        return $eventManager;
    }),

    WhoopsListener::class => \DI\object(WhoopsListener::class),
    \App\EventListener\ExceptionListener::class => \DI\object(\App\EventListener\ExceptionListener::class)
        ->constructor(\DI\get("template")),
    \App\EventListener\DispatcherExceptionListener::class => \DI\object(\App\EventListener\DispatcherExceptionListener::class)
        ->constructor(\DI\get("template")),

    'template' => \DI\object(\League\Plates\Engine::class)->constructor('./app/view/'),
    'router' => function () {
        return \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', ['App\Controller\IndexController', 'index']);
        });
    },
];
