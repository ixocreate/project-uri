<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace IxocreateTest\ProjectUri;

use Ixocreate\ProjectUri\Middleware\ProjectUriCheckMiddleware;
use Ixocreate\ProjectUri\ProjectUri;
use Ixocreate\ProjectUri\ProjectUriConfigurator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class ProjectUriCheckMiddlewareTest extends TestCase
{
    /**
     * @covers \Ixocreate\ProjectUri\Middleware\ProjectUriCheckMiddleware
     */
    public function testProcess()
    {
        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri('https://project-uri.test');

        $projectUri = new ProjectUri($configurator);

        $middleware = new ProjectUriCheckMiddleware($projectUri);

        $requestHandler = new class() implements RequestHandlerInterface {
            private $request;

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                $this->request = $request;
                return new Response();
            }

            public function getRequest()
            {
                return $this->request;
            }
        };

        $request = new ServerRequest([], [], new Uri('https://project-uri-something.test'));
        $response = $middleware->process($request, $requestHandler);
        $this->assertNull($requestHandler->getRequest());
        $this->assertInstanceOf(Response\RedirectResponse::class, $response);

        $request = new ServerRequest([], [], new Uri('https://project-uri.test'));
        $response = $middleware->process($request, $requestHandler);
        $this->assertEquals($request, $requestHandler->getRequest());
        $this->assertInstanceOf(Response::class, $response);
    }
}
