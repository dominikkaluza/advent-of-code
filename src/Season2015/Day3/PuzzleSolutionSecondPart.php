<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = FileSystem::read(__DIR__ . '/input.txt');

        $houses = [];
        $houses[0][0] = true;

        $santaPos = [
            'x' => 0,
            'y' => 0,
        ];
        $roboSantaPos = [
            'x' => 0,
            'y' => 0,
        ];

        for ($i = 0; $i < strlen($input); $i++) {
            if ($i % 2 === 0) {
                switch ($input[$i]) {
                    case '>':
                        $santaPos['x']++;
                        break;
                    case '<':
                        $santaPos['x']--;
                        break;
                    case '^':
                        $santaPos['y']++;
                        break;
                    case 'v':
                        $santaPos['y']--;
                        break;
                }

                $houses[$santaPos['x']][$santaPos['y']] = true;
            } else {
                switch ($input[$i]) {
                    case '>':
                        $roboSantaPos['x']++;
                        break;
                    case '<':
                        $roboSantaPos['x']--;
                        break;
                    case '^':
                        $roboSantaPos['y']++;
                        break;
                    case 'v':
                        $roboSantaPos['y']--;
                        break;
                }

                $houses[$roboSantaPos['x']][$roboSantaPos['y']] = true;
            }
        }

        $giftedHouses = 0;
        foreach ($houses as $houseLine) {
            $giftedHouses += count($houseLine);
        }

        return new IntegerResult($giftedHouses);
    }
}
