<?php
namespace AppTest;

use Prophecy\Argument;
use PHPUnit_Framework_TestCase;
use Penny\App;
use Penny\Container;
use Penny\Config\Loader;
use Penny\ExcpHandler\EventListener\WhoopsListener;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Zend\Diactoros\Uri;

class AppTest extends PHPUnit_Framework_TestCase
{
    public function testDispatcherErrorCallsListenerIndex()
    {
        $dispatcherExceptionListener = $this->prophesize(WhoopsListener::class);

        $response = $this->prophesize(Response::class);
        $request = (new Request())
            ->withUri(new Uri('/pnf'))
            ->withMethod('GET');

        $container = Container\PHPDiFactory::buildContainer(Loader::load());
        $container->set(WhoopsListener::class, $dispatcherExceptionListener->reveal());

        $app = new App($container);
        $app->run($request, $response->reveal());

        $dispatcherExceptionListener->onError(Argument::any())->shouldHaveBeenCalled();
    }
}
