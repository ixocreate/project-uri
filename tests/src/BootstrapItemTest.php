<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace IxocreateTest\ProjectUri;

use Ixocreate\ProjectUri\BootstrapItem\ProjectUriBootstrapItem;
use Ixocreate\ProjectUri\ProjectUriConfigurator;
use PHPUnit\Framework\TestCase;

class BootstrapItemTest extends TestCase
{
    /**
     * @covers \Ixocreate\ProjectUri\BootstrapItem\ProjectUriBootstrapItem
     */
    public function testBootstrapItem()
    {
        $item = new ProjectUriBootstrapItem();

        $configurator = $item->getConfigurator();

        $this->assertInstanceOf(ProjectUriConfigurator::class, $configurator);
        $this->assertEquals('projectUri', $item->getVariableName());
        $this->assertEquals('project-uri.php', $item->getFileName());
    }
}
