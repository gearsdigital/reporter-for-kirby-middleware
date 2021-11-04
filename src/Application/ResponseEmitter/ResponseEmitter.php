<?php
declare(strict_types=1);

namespace App\Application\ResponseEmitter;

use Psr\Http\Message\ResponseInterface;
use Slim\ResponseEmitter as SlimResponseEmitter;

class ResponseEmitter extends SlimResponseEmitter
{
    /**
     * {@inheritdoc}
     */
    public function emit(ResponseInterface $response): void
    {
        $allowedOrigins = ['http://localhost:8080', 'https://gearsdigital.github.io'];

        if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {

            $response = $response
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN'])
                ->withHeader(
                    'Access-Control-Allow-Headers',
                    'X-Requested-With, Content-Type, Accept, Origin, Authorization',
                )
                ->withHeader('Access-Control-Allow-Methods', 'POST')
                ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->withAddedHeader('Cache-Control', 'post-check=0, pre-check=0')
                ->withHeader('Pragma', 'no-cache');
        }

        if (ob_get_contents()) {
            ob_clean();
        }

        parent::emit($response);
    }
}
