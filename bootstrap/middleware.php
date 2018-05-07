<?php
declare(strict_types=1);
namespace KiwiSuite\ProjectUri;

use KiwiSuite\ApplicationHttp\Middleware\MiddlewareConfigurator;
use KiwiSuite\ProjectUri\Middleware\ProjectUriCheckMiddleware;

/** @var MiddlewareConfigurator $middleware */

$middleware->addMiddleware(ProjectUriCheckMiddleware::class);
