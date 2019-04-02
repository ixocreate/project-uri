<?php

declare(strict_types=1);

namespace IxocreateTest\ProjectUri;

use Ixocreate\ProjectUri\ProjectUri;
use Ixocreate\ProjectUri\ProjectUriConfigurator;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Uri;

/**
 * Class ProjectUriTest
 * @package IxocreateTest\ProjectUri
 */
class ProjectUriTest extends TestCase
{
    /**
     * @covers \Ixocreate\ProjectUri\ProjectUri
     */
    public function testMainUri()
    {
        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri('https://project-uri.test');

        $projectUri = new ProjectUri($configurator);

        $this->assertEquals(new Uri('https://project-uri.test'), $projectUri->getMainUri());
        $this->assertEquals(new Uri('https://project-uri.test'), $projectUri->getMainUrl());
    }

    /**
     *
     */
    public function testAlternativeUris()
    {
        $configurator = new ProjectUriConfigurator();
        $configurator->addAlternativeUri('test', 'https://project-uri-2.test');

        $projectUri = new ProjectUri($configurator);

        $alternativeUris = [
            'test' => new Uri('https://project-uri-2.test')
        ];

        $this->assertEquals($alternativeUris, $projectUri->getAlternativeUris());
        $this->assertEquals($alternativeUris['test'], $projectUri->getAlternativeUri('test'));
        $this->assertNull($projectUri->getAlternativeUri('not-found'));
    }

    /**
     *
     */
    public function testPossibleUrls()
    {
        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri('https://project-uri.test');
        $configurator->addAlternativeUri('test', 'https://project-uri-2.test');

        $projectUri = new ProjectUri($configurator);

        $possibleUris = [
            'test' => new Uri('https://project-uri-2.test'),
            'mainUri' => new Uri('https://project-uri.test')
        ];

        $this->assertEquals($possibleUris, $projectUri->getPossibleUrls());
    }

    public function testIsValidUrl()
    {
        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri('https://project-uri.test');
        $configurator->addAlternativeUri('test-1', 'https://project-uri-1.test');
        $configurator->addAlternativeUri('test-2', 'https://project-uri-2.test/subPath');

        $projectUri = new ProjectUri($configurator);

        $this->assertTrue($projectUri->isValidUrl(new Uri('https://project-uri.test')));
        $this->assertTrue($projectUri->isValidUrl(new Uri('https://project-uri-1.test')));
        $this->assertFalse($projectUri->isValidUrl(new Uri('https://project-uri-not-set.test')));
        $this->assertFalse($projectUri->isValidUrl(new Uri('http://project-uri.test')));
        $this->assertFalse($projectUri->isValidUrl(new Uri('https://project-uri.test:8080')));
        $this->assertFalse($projectUri->isValidUrl(new Uri('https://project-uri-2.test/path')));
        $this->assertFalse($projectUri->isValidUrl(new Uri('https://project-uri-2.test/withASpecialInvalidPath')));
    }

    public function testGetPathWithoutBase()
    {
        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri('https://project-uri.test');
        $configurator->addAlternativeUri('test-2', 'https://project-uri-2.test/subPath/');

        $projectUri = new ProjectUri($configurator);

        $this->assertEquals('', $projectUri->getPathWithoutBase(new Uri('https://project-uri.test')));
        $this->assertEquals('/withPath', $projectUri->getPathWithoutBase(new Uri('https://project-uri.test/withPath')));

        $this->assertEquals('', $projectUri->getPathWithoutBase(new Uri('https://project-uri-not-found.test')));
        $this->assertEquals('', $projectUri->getPathWithoutBase(new Uri('http://project-uri.test')));
        $this->assertEquals('', $projectUri->getPathWithoutBase(new Uri('https://project-uri.test:8080')));
        $this->assertEquals('', $projectUri->getPathWithoutBase(new Uri('https://project-uri-2.test/withASpecialInvalidPath')));
        $this->assertEquals('/pathToGlory', $projectUri->getPathWithoutBase(new Uri('https://project-uri-2.test/subPath/pathToGlory')));
    }

    /**
     * @covers \Ixocreate\ProjectUri\ProjectUri::serialize
     * @covers \Ixocreate\ProjectUri\ProjectUri::unserialize
     */
    public function testSerialization()
    {
        $configurator = new ProjectUriConfigurator();
        $configurator->setMainUri('https://project-uri.test');
        $configurator->addAlternativeUri('test', 'https://project-uri-2.test');

        $projectUri = new ProjectUri($configurator);

        $serialized = \serialize($projectUri);
        $restoredConfig = \unserialize($serialized);

        $this->assertEquals($projectUri->getMainUri(), $restoredConfig->getMainUri());
        $this->assertEquals($projectUri->getAlternativeUris(), $restoredConfig->getAlternativeUris());
    }
}
