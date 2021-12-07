<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day4;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt', PHP_EOL . PHP_EOL);

        $lines = $input->getLines();
        $drawnNumbers = explode(',', $lines[0]);
        unset($lines[0]);

        $grids = [];

        foreach ($lines as $line) {
            $grids[] = new Grid($line);
        }

        foreach ($drawnNumbers as $drawnNumber) {
            foreach ($grids as $grid) {
                $grid->markNumber($drawnNumber);

                if ($grid->hasWon()) {
                    return new IntegerResult($grid->getScore($drawnNumber));
                }
            }
        }

        return new IntegerResult(0);
    }
}
