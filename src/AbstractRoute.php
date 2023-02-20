<?php

namespace VampireAPI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AbstractRoute
 * @package VampireAPI
 */
abstract class AbstractRoute
{
    /**
     * @var array
     */
    protected array $help = [];

    /**
     * @return object
     */
    public function getHelp(): object
    {
        return (object) $this->help;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    abstract public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface;

    abstract public function generate($type = '', $gender = '', $laban = false): array;

    /**
     * @param ResponseInterface $response
     * @param array $outArray
     * @return ResponseInterface
     */
    protected function outputResponse(ResponseInterface $response, array $outArray) : ResponseInterface
    {
        $response->getBody()->write(json_encode($outArray, JSON_PRETTY_PRINT));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
