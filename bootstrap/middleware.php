<?php
declare(strict_types=1);
namespace Ixocreate\Package\ProjectUri;

use Ixocreate\Application\Http\Middleware\MiddlewareConfigurator;
use Ixocreate\Package\ProjectUri\Middleware\ProjectUriCheckMiddleware;

/** @var MiddlewareConfigurator $middleware */

$middleware->addMiddleware(ProjectUriCheckMiddleware::class);
