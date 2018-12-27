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

use Ixocreate\Contract\Application\ConfigProviderInterface;

final class ConfigProvider implements ConfigProviderInterface
{
    public function __invoke(): array
    {
        return [
            'project-uri' => [
                'mainUrl' => '',
                'possibleUrls' => [],

            ],
        ];
    }
}
