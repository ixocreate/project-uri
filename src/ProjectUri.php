<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\ProjectUri;

use Psr\Http\Message\UriInterface;

final class ProjectUri
{
    /**
     * @var UriInterface
     */
    private $mainUrl;

    /**
     * @var UriInterface[]
     */
    private $possibleUrls;

    public function __construct(UriInterface $mainUrl, array $possibleUrls)
    {
        $this->mainUrl = $mainUrl;
        $this->possibleUrls = $possibleUrls;
    }

    /**
     * @return UriInterface
     */
    public function getMainUrl(): UriInterface
    {
        return $this->mainUrl;
    }

    /**
     * @return UriInterface[]
     */
    public function getPossibleUrls(): array
    {
        return $this->possibleUrls;
    }

    /**
     * @param UriInterface $uri
     * @return bool
     */
    public function isValidUrl(UriInterface $uri) : bool
    {
        foreach ($this->possibleUrls as $possibleUrl) {
            if ($uri->getHost() !== $possibleUrl->getHost()) {
                continue;
            }

            if ($uri->getScheme() !== $possibleUrl->getScheme()) {
                continue;
            }

            if ($uri->getPort() !== $possibleUrl->getPort()) {
                continue;
            }

            $pathLength = \mb_strlen($possibleUrl->getPath());
            if ($pathLength > 0) {
                if (\mb_strlen($uri->getPath()) < $pathLength) {
                    continue;
                }

                if (\mb_substr($uri->getPath(), 0, $pathLength) !== $possibleUrl->getPath()) {
                    continue;
                }
            }

            return true;
        }

        return false;
    }

    public function getPathWithoutBase(UriInterface $uri) : string
    {
        foreach ($this->possibleUrls as $possibleUrl) {
            if ($uri->getHost() !== $possibleUrl->getHost()) {
                continue;
            }

            if ($uri->getScheme() !== $possibleUrl->getScheme()) {
                continue;
            }

            if ($uri->getPort() !== $possibleUrl->getPort()) {
                continue;
            }

            $pathLength = \mb_strlen($possibleUrl->getPath());
            if ($pathLength > 0) {
                if (\mb_strlen($uri->getPath()) < $pathLength) {
                    continue;
                }

                if (\mb_substr($uri->getPath(), 0, $pathLength) !== $possibleUrl->getPath()) {
                    continue;
                }

                return \mb_substr($uri->getPath(), $pathLength);
            }

            return $uri->getPath();
        }

        return "";
    }
}
