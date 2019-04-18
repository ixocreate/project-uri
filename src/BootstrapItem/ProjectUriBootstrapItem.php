<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\ProjectUri\BootstrapItem;

use Ixocreate\Application\BootstrapItemInterface;
use Ixocreate\Application\ConfiguratorInterface;
use Ixocreate\Package\ProjectUri\ProjectUriConfigurator;

final class ProjectUriBootstrapItem implements BootstrapItemInterface
{
    /**
     * @return ConfiguratorInterface
     */
    public function getConfigurator(): ConfiguratorInterface
    {
        return new ProjectUriConfigurator();
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return 'projectUri';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'project-uri.php';
    }
}
