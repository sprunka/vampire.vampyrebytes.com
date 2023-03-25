<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

class Clan extends AbstractRoute
{
    private int $counter = 0;

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $type = strtolower($args['sect']) ?? 'general';
        return parent::outputResponse($response, $this->generate(type: $type));
    }

    public function generate($type = 'anarch', $gender = '', $laban = false): array
    {
        $this->counter++;
        if ($this->counter >= 10) {
            return ['clan' => 'Malkavian'];
        }

        $roll = rand(1, 10);

        if ($type === 'anarch') {
            if ($roll <= 2) {
                $clan = 'Brujah';
            } elseif ($roll <= 4) {
                $clan = 'Gangrel';
            } elseif ($roll <= 5) {
                $clan = 'Ministry';
            } elseif ($roll <= 7) {
                $clan = 'Caitiff';
            } elseif ($roll <= 9) {
                $clan = ($this->generate('camarilla', '', ''))['clan'];
            } else {
                $clan = ($this->generate('other', '', ''))['clan'];
            }
        } elseif ($type === 'Camarilla') {
            if ($roll <= 1) {
                $clan = ($this->generate('anarch', '', ''))['clan'];
            } elseif ($roll <= 2) {
                $clan = 'Gangrel or Brujah';
            } elseif ($roll <= 3) {
                $clan = 'Banu Haqim';
            } elseif ($roll <= 4) {
                $clan = 'Malkavian';
            } elseif ($roll <= 5) {
                $clan = 'Nosferatu';
            } elseif ($roll <= 6) {
                $clan = 'Toreador';
            } elseif ($roll <= 7) {
                $clan = 'Tremere';
            } elseif ($roll <= 8) {
                $clan = 'Ventrue';
            } elseif ($roll <= 9) {
                $clan = 'Choose: Malkavian, Nosferatu, Toreador, Tremere or Ventrue';
            } else {
                $clan = ($this->generate('other', '', ''))['clan'];
            }
        } else {
            if ($roll <= 3) {
                $clan = 'Hecata';
            } elseif ($roll <= 6) {
                $clan = 'Lasombra';
            } elseif ($roll <= 7) {
                $clan = 'Ravnos';
            } elseif ($roll <= 8) {
                $clan = 'Salubri';
            } else {
                $clan = 'Tzimisce';
            }
        }

        return [
            'tableTitle' => 'Clan',
            'clan' => $clan,
        ];
    }

}