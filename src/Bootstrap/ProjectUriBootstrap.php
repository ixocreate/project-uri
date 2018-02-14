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
namespace KiwiSuite\ProjectUri\Bootstrap;

use KiwiSuite\Application\Bootstrap\BootstrapInterface;
use KiwiSuite\Application\ConfiguratorItem\ConfiguratorRegistry;
use KiwiSuite\Application\ConfiguratorItem\ServiceManagerConfiguratorItem;
use KiwiSuite\Application\Service\ServiceRegistry;
use KiwiSuite\ApplicationHttp\ConfiguratorItem\MiddlewareConfiguratorItem;
use KiwiSuite\ProjectUri\Factory\ProjectUriFactory;
use KiwiSuite\ProjectUri\Middleware\ProjectUriCheckMiddleware;
use KiwiSuite\ProjectUri\ProjectUri;
use KiwiSuite\ServiceManager\ServiceManager;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

final class ProjectUriBootstrap implements BootstrapInterface
{

    /**
     * @param ConfiguratorRegistry $configuratorRegistry
     */
    public function configure(ConfiguratorRegistry $configuratorRegistry): void
    {
        /** @var ServiceManagerConfigurator $serviceManagerConfigurator */
        $serviceManagerConfigurator = $configuratorRegistry->get(ServiceManagerConfiguratorItem::class);

        $serviceManagerConfigurator->addFactory(ProjectUri::class, ProjectUriFactory::class);

        $configuratorRegistry->get(MiddlewareConfiguratorItem::class)->addFactory(ProjectUriCheckMiddleware::class);
    }

    /**
     * @param ServiceRegistry $serviceRegistry
     */
    public function addServices(ServiceRegistry $serviceRegistry): void
    {
    }

    /**
     * @return array|null
     */
    public function getConfiguratorItems(): ?array
    {
        return null;
    }

    /**
     * @return array|null
     */
    public function getDefaultConfig(): ?array
    {
        return [
            'project-uri' => [
                'mainUrl' => '',
                'possibleUrls' => [],

            ],
        ];
    }

    /**
     * @param ServiceManager $serviceManager
     */
    public function boot(ServiceManager $serviceManager): void
    {
    }
}
