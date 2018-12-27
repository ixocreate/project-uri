<?php
declare(strict_types=1);
namespace Ixocreate\ProjectUri;

use Ixocreate\ProjectUri\Factory\ProjectUriFactory;
use Ixocreate\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(ProjectUri::class, ProjectUriFactory::class);
