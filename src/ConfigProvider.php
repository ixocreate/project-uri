<?php
namespace KiwiSuite\ProjectUri;

use KiwiSuite\Contract\Application\ConfigProviderInterface;

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
