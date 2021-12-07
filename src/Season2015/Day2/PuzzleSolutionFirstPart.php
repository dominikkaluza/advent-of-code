<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day2;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $totalPaperArea = 0;

        foreach ($input->getLines() as $box) {
            $dimensions = explode('x', $box);
            $dimensions = array_map(
                function ($dimension): int {
                    return (int)$dimension;
                },
                $dimensions
            );
            sort($dimensions);

            $surfaceArea = 2 * $dimensions[0] * $dimensions[1]
                + 2 * $dimensions[1] * $dimensions[2]
                + 2 * $dimensions[2] * $dimensions[0];

            $slackArea = $dimensions[0] * $dimensions[1];

            $totalPaperArea += $surfaceArea + $slackArea;
        }

        return new IntegerResult($totalPaperArea);
    }
}
