<?php
return [
    'event_manager' => \DI\decorate(function($eventManager, $container) {
        $eventManager->attach("dispatch_error", [$container->get(\App\EventListener\DispatcherExceptionListener::class), "onError"]);
        $eventManager->attach("*_error", [$container->get(\App\EventListener\ExceptionListener::class), "onError"]);
        return $eventManager;
    }),
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
