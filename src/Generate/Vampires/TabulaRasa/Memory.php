<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use CommonRoutes\AbstractRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\Lessons\WhatDidYouLearnHuman;
use VampireAPI\Generate\Vampires\TabulaRasa\Lessons\WhatDidYouLearnVampire;
use VampireAPI\Generate\Vampires\TabulaRasa\Memories\HowDidItEnd;
use VampireAPI\Generate\Vampires\TabulaRasa\Memories\HowDidYouFeel;
use VampireAPI\Generate\Vampires\TabulaRasa\Memories\WhatWasHappening;
use VampireAPI\Generate\Vampires\TabulaRasa\Memories\WhatWasTheirMotive;
use VampireAPI\Generate\Vampires\TabulaRasa\Memories\WhereDidThisHappen;
use VampireAPI\Generate\Vampires\TabulaRasa\Memories\WhoWasWithYou;

class Memory extends AbstractRoute
{
    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $memories = [];

        // If memory type is provided, generate only that memory
        if (isset($args['memory'])) {
            $type = strtolower($args['memory']);
            $memories = $this->generate($type);
            return parent::outputResponse($response, $memories);
        }
        // Otherwise, generate all memories
        $memories = array_merge($memories, $this->generate('what_was_happening'));
        $memories = array_merge($memories, $this->generate('who_was_with_you'));
        $memories = array_merge($memories, $this->generate('what_was_their_motive'));
        $memories = array_merge($memories, $this->generate('where_did_it_happen'));
        $memories = array_merge($memories, $this->generate('how_did_you_feel'));
        $memories = array_merge($memories, $this->generate('how_did_it_end'));

        if (isset($args['type'])) {
            $type = strtolower($args['type']);
            $memories = array_merge($memories, $this->generate($type));
        }

        return parent::outputResponse($response, $memories);
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        switch ($type) {
            case 'who_was_with_you':
                $generator = new WhoWasWithYou();
                break;
            case 'what_was_their_motive':
                $generator = new WhatWasTheirMotive();
                break;
            case 'where_did_it_happen':
                $generator = new WhereDidThisHappen();
                break;
            case 'how_did_you_feel':
                $generator = new HowDidYouFeel();
                break;
            case 'how_did_it_end':
                $generator = new HowDidItEnd();
                break;
            case 'what_was_happening':
                $generator = new WhatWasHappening();
                break;
            case 'kindred':
                $generator = new WhatDidYouLearnVampire();
                break;
            case 'mortal':
            default:
                $generator = new WhatDidYouLearnHuman();
                break;
        }

        return $generator->generate();
    }
}
