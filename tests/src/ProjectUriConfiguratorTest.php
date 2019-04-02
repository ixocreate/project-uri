<?php

declare(strict_types=1);

namespace IxocreateTest\ProjectUri;

use Ixocreate\Contract\Application\ServiceRegistryInterface;
use Ixocreate\ProjectUri\ProjectUri;
use Ixocreate\ProjectUri\ProjectUriConfigurator;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Uri;

class ProjectUriConfiguratorTest extends TestCase
{
    public function testMainUri()
    {
        $configurator = new ProjectUriConfigurator();
        $this->assertEquals($configurator->getMainUri(), new Uri('/'));

        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri('https://project-uri.test');
        $this->assertEquals($configurator->getMainUri(), new Uri('https://project-uri.test'));
    }

    /**
     * @param $uri
     * @param $exception
     * @dataProvider provideMainUriError
     */
    public function testMainUriError($uri, $exception)
    {
        $this->expectException($exception);

        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri($uri);
    }

    public function provideMainUriError()
    {
        return [
            ['ftp://invalid.com', \InvalidArgumentException::class],
        ];
    }

    public function testAlternativeUris()
    {
        $configurator = new ProjectUriConfigurator();

        $configurator->addAlternativeUri('test-1', 'https://project-uri.test');
        $configurator->addAlternativeUri('test-2', 'http://project-uri-2.test');

        $alternativeUris = [
            'test-1' => new Uri('https://project-uri.test'),
            'test-2' => new Uri('http://project-uri-2.test')
        ];

        $this->assertEquals($alternativeUris, $configurator->getAlternativeUris());
    }

    public function testRemoveAlternativeUris()
    {
        $configurator = new ProjectUriConfigurator();

        $configurator->addAlternativeUri('test-1', 'https://project-uri.test');
        $configurator->addAlternativeUri('test-2', 'http://project-uri-2.test');

        $alternativeUris = [
            'test-2' => new Uri('http://project-uri-2.test')
        ];

        $configurator->removeAlternativeUri('test-1');

        $this->assertEquals($alternativeUris, $configurator->getAlternativeUris());
    }

    public function testRegisterService()
    {
        $serviceRegistry = $this->getMockBuilder(ServiceRegistryInterface::class)->getMock();
        $serviceRegistry->method('get')->willThrowException(new \InvalidArgumentException('Fail: ServiceRegistry:get should not be called!'));

        $serviceRegistry
            ->expects($this->once())
            ->method('add')
            ->with($this->equalTo(ProjectUri::class), $this->isInstanceOf(ProjectUri::class));

        $configurator = new ProjectUriConfigurator();
        $configurator->registerService($serviceRegistry);

    }
}
