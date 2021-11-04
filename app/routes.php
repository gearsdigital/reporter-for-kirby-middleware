<?php

declare(strict_types=1);

use App\Application\Actions\Report\ReportAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write(':)');

        return $response;
    });

    $app->post('/', ReportAction::class);
};
