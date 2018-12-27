<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
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
