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
namespace Ixocreate\ProjectUri\Factory;

use Ixocreate\Config\Config;
use Ixocreate\Contract\ServiceManager\FactoryInterface;
use Ixocreate\Contract\ServiceManager\ServiceManagerInterface;
use Ixocreate\ProjectUri\ProjectUri;
use Zend\Diactoros\Uri;

final class ProjectUriFactory implements FactoryInterface
{

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @return mixed
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        $possibleUrls = $container->get(Config::class)->get('project-uri.possibleUrls', []);
        if (!\is_array($possibleUrls)) {
            $possibleUrls = [];
        }
        $possibleUrls[] = $container->get(Config::class)->get('project-uri.mainUrl', '');
        $possibleUrls = \array_unique(\array_values($possibleUrls));
        $possibleUrls = \array_filter($possibleUrls);
        $possibleUrls = \array_map(function ($value) {
            return new Uri(\rtrim($value, '/'));
        }, $possibleUrls);

        //TODO check absolute url
        return new ProjectUri(
            new Uri(\rtrim($container->get(Config::class)->get('project-uri.mainUrl', ''), '/')),
            $possibleUrls
        );
    }
}
