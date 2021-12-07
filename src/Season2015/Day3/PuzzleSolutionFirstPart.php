<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = FileSystem::read(__DIR__ . '/input.txt');

        $houses = [];
        $houses[0][0] = true;

        $pos = [
            'x' => 0,
            'y' => 0,
        ];

        for ($i = 0; $i < strlen($input); $i++) {
            switch ($input[$i]) {
                case '>':
                    $pos['x']++;
                    break;
                case '<':
                    $pos['x']--;
                    break;
                case '^':
                    $pos['y']++;
                    break;
                case 'v':
                    $pos['y']--;
                    break;
            }

            $houses[$pos['x']][$pos['y']] = true;
        }

        $giftedHouses = 0;
        foreach ($houses as $houseLine) {
            $giftedHouses += count($houseLine);
        }

        return new IntegerResult($giftedHouses);
    }
}
