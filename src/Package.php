<?php
/**
 * kiwi-suite/database (https://github.com/kiwi-suite/project-uri)
 *
 * @package kiwi-suite/project-uri
 * @see https://github.com/kiwi-suite/project-uri
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\ProjectUri;

use Ixocreate\Contract\Application\ConfiguratorRegistryInterface;
use Ixocreate\Contract\Application\PackageInterface;
use Ixocreate\Contract\Application\ServiceRegistryInterface;
use Ixocreate\Contract\ServiceManager\ServiceManagerInterface;

final class Package implements PackageInterface
{

    /**
     * @param ConfiguratorRegistryInterface $configuratorRegistry
     */
    public function configure(ConfiguratorRegistryInterface $configuratorRegistry): void
    {
    }

    /**
     * @param ServiceRegistryInterface $serviceRegistry
     */
    public function addServices(ServiceRegistryInterface $serviceRegistry): void
    {
    }

    /**
     * @return array|null
     */
    public function getBootstrapItems(): ?array
    {
        return null;
    }

    /**
     * @return array|null
     */
    public function getConfigProvider(): ?array
    {
        return [
            ConfigProvider::class,
        ];
    }

    /**
     * @param ServiceManagerInterface $serviceManager
     */
    public function boot(ServiceManagerInterface $serviceManager): void
    {
    }

    /**
     * @return null|string
     */
    public function getBootstrapDirectory(): ?string
    {
        return __DIR__ . '/../bootstrap';
    }

    /**
     * @return null|string
     */
    public function getConfigDirectory(): ?string
    {
        return null;
    }

    /**
     * @return array|null
     */
    public function getDependencies(): ?array
    {
        return null;
    }
}
