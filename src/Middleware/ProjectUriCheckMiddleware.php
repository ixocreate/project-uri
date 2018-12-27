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
namespace Ixocreate\ProjectUri\Middleware;

use Ixocreate\ProjectUri\ProjectUri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;

final class ProjectUriCheckMiddleware implements MiddlewareInterface
{
    /**
     * @var ProjectUri
     */
    private $projectUri;

    /**
     * ProjectCheckMiddleware constructor.
     * @param ProjectUri $projectUri
     */
    public function __construct(ProjectUri $projectUri)
    {
        $this->projectUri = $projectUri;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->projectUri->isValidUrl($request->getUri())) {
            $uri = $request->getUri()->withPath($this->projectUri->getPathWithoutBase($request->getUri()));
            return $handler->handle($request->withUri($uri));
        }

        return new RedirectResponse($this->projectUri->getMainUrl());
    }
}
