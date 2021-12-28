<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day17;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        // target area: x=20..30, y=-10..-5
        preg_match('/^target area: x=([-0-9]+)..([-0-9]+), y=([-0-9]+)..([-0-9]+)$/', $input->getLines()[0], $matches);

        $targetArea = [
            'x1' => (int)$matches[1],
            'x2' => (int)$matches[2],
            'y1' => (int)$matches[3],
            'y2' => (int)$matches[4],
        ];

        $highestEverY = 0;

        for ($x = 0; $x <= $targetArea['x1']; $x++) {
            echo $x .PHP_EOL;
            for ($y = 0; $y <= 1000; $y++) {
                $probe = [
                    'position' => [
                        'x' => 0,
                        'y' => 0,
                    ],
                    'velocity' => [
                        'x' => $x,
                        'y' => $y,
                    ],
                ];

                $highestY = 0;

                while (true) {
                    $probe = $this->step($probe);

//                    echo "[{$probe['position']['x']}, {$probe['position']['y']}]\n";

                    $highestY = $highestY < $probe['position']['y'] ? $probe['position']['y'] : $highestY;

                    if ($this->isInTargetArea($probe, $targetArea)) {
                        $highestEverY = $highestEverY < $highestY ? $highestY : $highestEverY;

//                        echo "In target area\n";
                        break;
                    }

                    if ($this->isOverTargetArea($probe, $targetArea)) {
//                        echo "Over\n";
                        break;
                    }
                }

            }
        }

        return new IntegerResult($highestEverY);
    }


    private function step($probe): array
    {
        $probe['position']['x'] += $probe['velocity']['x'];

        $probe['position']['y'] += $probe['velocity']['y'];

        if ($probe['velocity']['x'] !== 0) {
            $probe['velocity']['x'] += $probe['velocity']['x'] > 0 ? -1 : 1;
        }

        $probe['velocity']['y']--;

        return $probe;
    }


    private function isInTargetArea($probe, array $targetArea): bool
    {
        $position = $probe['position'];

        return $position['x'] >= $targetArea['x1'] && $position['x'] <= $targetArea['x2']
            && $position['y'] >= $targetArea['y1'] && $position['y'] <= $targetArea['y2'];
    }


    private function isOverTargetArea($probe, array $targetArea): bool
    {
        $position = $probe['position'];

        return $position['x'] > $targetArea['x2']
            || $position['y'] < $targetArea['y1'];
    }
}
