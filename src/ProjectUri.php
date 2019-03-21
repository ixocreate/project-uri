<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\ProjectUri;

use Ixocreate\Contract\Application\SerializableServiceInterface;
use Psr\Http\Message\UriInterface;

final class ProjectUri implements SerializableServiceInterface
{
    /**
     * @var UriInterface
     */
    private $mainUri;

    /**
     * @var UriInterface[]
     */
    private $alternativeUris;

    public function __construct(ProjectUriConfigurator $configurator)
    {
        $this->mainUri = $configurator->getMainUri();
        $this->alternativeUris = $configurator->getAlternativeUris();
        $this->alternativeUris['mainUri'] = $this->mainUri;
    }

    /**
     * @return UriInterface
     */
    public function getMainUri(): UriInterface
    {
        return $this->mainUri;
    }

    /**
     * @return UriInterface
     * @deprecated
     */
    public function getMainUrl(): UriInterface
    {
        return $this->mainUri;
    }

    /**
     * @return UriInterface[]
     */
    public function getAlternativeUris(): array
    {
        return $this->alternativeUris;
    }

    public function getAlternativeUri($name): UriInterface
    {
        return $this->alternativeUris[$name];
    }

    /**
     * @return UriInterface[]
     * * @deprecated
     */
    public function getPossibleUrls(): array
    {
        return $this->alternativeUris;
    }

    /**
     * @param UriInterface $uri
     * @return bool
     */
    public function isValidUrl(UriInterface $uri) : bool
    {
        foreach ($this->alternativeUris as $possibleUrl) {
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
        foreach ($this->alternativeUris as $possibleUrl) {
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

        return '';
    }

    public function serialize()
    {
        return \serialize([
            'mainUri' => $this->mainUri,
            'alternativeUris' => $this->alternativeUris
        ]);
    }

    public function unserialize($serialized)
    {
        $data = \unserialize($serialized);
        $this->mainUri = $data['mainUri'];
        $this->mainUri = $data['alternativeUris'];
    }
}
