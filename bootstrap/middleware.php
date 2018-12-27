<?php
declare(strict_types=1);
namespace Ixocreate\ProjectUri;

use Ixocreate\ApplicationHttp\Middleware\MiddlewareConfigurator;
use Ixocreate\ProjectUri\Middleware\ProjectUriCheckMiddleware;

/** @var MiddlewareConfigurator $middleware */

$middleware->addMiddleware(ProjectUriCheckMiddleware::class);
