<?php
declare(strict_types=1);
namespace KiwiSuite\ProjectUri;

use KiwiSuite\ProjectUri\Factory\ProjectUriFactory;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(ProjectUri::class, ProjectUriFactory::class);
