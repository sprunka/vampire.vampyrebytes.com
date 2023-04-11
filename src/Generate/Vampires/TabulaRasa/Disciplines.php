<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use CommonRoutes\AbstractRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Disciplines extends AbstractRoute
{
    const CLAN_TO_DISCIPLINES = [
        'Banu Haqim' => ['Blood Sorcery', 'Celerity', 'Obfuscate'],
        'Brujah' => ['Celerity', 'Potence', 'Presence'],
        'Gangrel' => ['Animalism', 'Fortitude', 'Protean'],
        'Hecata' => ['Auspex', 'Fortitude', 'Oblivion'],
        'Lasombra' => ['Dominate', 'Oblivion', 'Potence'],
        'Malkavian' => ['Auspex', 'Dominate', 'Obfuscate'],
        'Ministry' => ['Obfuscate', 'Presence', 'Protean'],
        'Nosferatu' => ['Animalism', 'Obfuscate', 'Potence'],
        'Ravnos' => ['Animalism', 'Obfuscate', 'Presence'],
        'Salubri' => ['Auspex', 'Dominate', 'Fortitude'],
        'Toreador' => ['Auspex', 'Celerity', 'Presence'],
        'Tremere' => ['Auspex', 'Blood Sorcery', 'Dominate'],
        'Tzimisce' => ['Animalism', 'Dominate', 'Protean'],
        'Ventrue' => ['Dominate', 'Fortitude', 'Presence'],
    ];

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $type = isset($args['clan']) ? ucwords(strtolower($args['clan'])) : 'Caitiff';
        return parent::outputResponse($response, $this->generate($type));
    }

    public function generate($type = 'Caitiff', $gender = '', $laban = false): array
    {
        $oldRoll = 0;
        $clan = $type;
        $clan = $clan ?: 'Caitiff';

        $roll = rand(1, 10);
        if ($roll === 10 || $type === 'Caitiff') {
            do {
                $sect = (new Sect())->generate()['sect'];
                $clan = (new Clan())->generate(type: $sect)['clan'];
            } while (!array_key_exists($clan, self::CLAN_TO_DISCIPLINES));
            $oldRoll = $roll;
            $roll = rand(1, 9);
        }

        $disciplines = self::CLAN_TO_DISCIPLINES[$clan];
        $discipline = $disciplines[floor(($roll - 1) / 3)];

        if ($oldRoll === 10) {
            $discipline .= ' or Player\'s Choice';
        }

        return [
            'tableTitle' => 'Discipline',
            'clan' => $clan,
            'discipline' => $discipline,
        ];
    }
}
