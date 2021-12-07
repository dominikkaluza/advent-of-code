<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $numbers = $input->getLinesAsNumbers();

        $increasedMeasurements = 0;

        for ($i = 1; $i <= $input->getSize(); $i++) {
            if ($numbers[$i] > $numbers[$i - 1]) {
                $increasedMeasurements++;
            }
        }

        return new IntegerResult($increasedMeasurements);
    }
}
