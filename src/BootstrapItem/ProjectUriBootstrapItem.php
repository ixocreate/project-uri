<?php

declare(strict_types=1);

namespace Ixocreate\ProjectUri\BootstrapItem;

use Ixocreate\Contract\Application\BootstrapItemInterface;
use Ixocreate\Contract\Application\ConfiguratorInterface;
use Ixocreate\ProjectUri\ProjectUriConfigurator;

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
