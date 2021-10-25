<?php

namespace ForceVendorCore;

require_once 'dependencies.php';

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions($dependencies);

$app = AppFactory::create(null, $containerBuilder->build());

$app->addRoutingMiddleware();

$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(new ErrorHandler());

require_once 'routes.php';

$app->run();
