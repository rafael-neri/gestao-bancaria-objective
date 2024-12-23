<?php

namespace App\Renderer;

use Psr\Http\Message\ResponseInterface as Response;

class JsonRenderer
{
    public function json(Response $response, mixed $data = null): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json');
        $data = (string)json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
        $response->getBody()->write($data);
        return $response;
    }
}
