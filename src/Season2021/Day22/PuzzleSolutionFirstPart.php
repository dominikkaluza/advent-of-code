<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day22;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const CUTOFF = 20;

    public function getResult(): Result
    {
        $lines = (new LinesInput(__DIR__ . '/input.txt'))
            ->mapLines(function ($line) {
                preg_match('/^([a-z]+) x=([\-0-9]+)..([\-0-9]+),y=([\-0-9]+)..([\-0-9]+),z=([\-0-9]+)..([\-0-9]+)$/', $line, $matches);

                return [
                    'signal' => $matches[1],
                    'x1' => (int)$matches[2],
                    'x2' => (int)$matches[3],
                    'y1' => (int)$matches[4],
                    'y2' => (int)$matches[5],
                    'z1' => (int)$matches[6],
                    'z2' => (int)$matches[7],
                ];
            });

        $cubes = [];

        foreach ($lines as $i => $line) {
            if($i === self::CUTOFF) {
                break;
            }

            for ($x = $line['x1']; $x <= $line['x2']; $x++) {
                for ($y = $line['y1']; $y <= $line['y2']; $y++) {
                    for ($z = $line['z1']; $z <= $line['z2']; $z++) {
                        $cubes[$x][$y][$z] = $line['signal'] === 'on';
                    }
                }
            }
        }

        $count = 0;
        for ($x = -50; $x <= 50; $x++) {
            for ($y = -50; $y <= 50; $y++) {
                for ($z = -50; $z <= 50; $z++) {
                    if(isset($cubes[$x][$y][$z]) && $cubes[$x][$y][$z] === true) {
                        $count++;
                    }
                }
            }
        }

        return new IntegerResult($count);
    }
}
