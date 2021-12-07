<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day1;

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
        $numbers = $input->getLinesAsNumbers();

        $increasedMeasurements = 0;

        for ($i = 3; $i <= $input->getSize(); $i++) {
            $firstWindow = $numbers[$i - 1] + $numbers[$i - 2] + $numbers[$i - 3];
            $secondWindow = $numbers[$i] + $numbers[$i - 1] + $numbers[$i - 2];

            if ($secondWindow > $firstWindow) {
                $increasedMeasurements++;
            }
        }

        return new IntegerResult($increasedMeasurements);
    }
}
