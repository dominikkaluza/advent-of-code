<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day2;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $totalLRibbonLength = 0;

        foreach ($input->getLines() as $box) {
            $dimensions = explode('x', $box);
            $dimensions = array_map(
                function ($dimension): int {
                    return (int)$dimension;
                },
                $dimensions
            );
            sort($dimensions);

            $ribbonLength = 2 * $dimensions[0] + 2 * $dimensions[1];
            $bowLength = $dimensions[0] * $dimensions[1] * $dimensions[2];

            $totalLRibbonLength += $ribbonLength + $bowLength;
        }

        return new IntegerResult($totalLRibbonLength);
    }
}
