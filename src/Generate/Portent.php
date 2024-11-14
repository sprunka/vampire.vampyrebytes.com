<?php

namespace VampireAPI\Generate;

use CommonRoutes\AbstractRoute;
use CommonRoutes\Generic\ListFactory;
use CommonRoutes\Generic\RecordFactory;
use CommonRoutes\Generic\RecordList;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Portent extends AbstractRoute
{
    protected RecordList $raw_portents;
    protected RecordList $gpt_portents;

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $type = isset($args['type']) ? strtolower($args['type']) : 'raw';
        return parent::outputResponse($response, $this->generate(type: $type));
    }

    public function __construct(ListFactory $listFactory, RecordFactory $recordFactory)
    {
        $fullList = $listFactory::create();
        $gptList = $listFactory::create();
        $path = dirname(__DIR__, 2) . '/json_src/portents.json';
        if (!file_exists($path)) {
            throw new \Exception("File not found: " . $path);
        } else {
            $fullList->loadFile($path, false);
            $this->raw_portents = $fullList;
        }

        $path = dirname(__DIR__, 2) . '/json_src/portents_gpt.json';
        if (!file_exists($path)) {
            throw new \Exception("File not found: " . $path);
        } else {
            $gptList->loadFile($path, false);
            $this->gpt_portents = $gptList;
        }
    }

    public function generate($type = 'raw', $gender = '', $laban = false): array
    {
        //$type "raw" or custom pattern
        $type = $type ?? 'raw';
$supportTypes = ['raw', 'gpt', 'mixed'];

        if (!in_array(needle: $type,haystack: $supportTypes)) {
            return ['tableTitle' => 'Portent'] + ['portent' => 'Custom Patterns not Implemented Yet'];
        }

        $result = $type;
        $portentRoll = rand(0, 49);
        if ($type === 'raw') {
            $result = $this->raw_portents->getRecordByKey('events')->{$portentRoll};
        }
        if ($type === 'gpt') {
            $result = $this->gpt_portents->getRecordByKey('events')->{$portentRoll};
        }
        if ($type === 'mixed') {
            $results[] = $this->gpt_portents->getRecordByKey('events')->{$portentRoll};
            $results[] = $this->raw_portents->getRecordByKey('events')->{$portentRoll};
            $result = $results[array_rand($results)];

        }

        return ['tableTitle' => 'Portent', 'portent' => $result];

    }
}