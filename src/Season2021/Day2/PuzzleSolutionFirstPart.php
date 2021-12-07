<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day2;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use AdventOfCode\Season2020\Day2\PasswordInput;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        /** @var Instruction[] $instructions */
        $instructions = $input->mapLines(
            function (string $instructionLine): Instruction {
                return new Instruction($instructionLine);
            }
        );

        $horizontalPosition = 0;
        $depth = 0;

        foreach ($instructions as $instruction) {
            if ($instruction->isForward()) {
                $horizontalPosition += $instruction->getValue();
            }

            if ($instruction->isDown()) {
                $depth += $instruction->getValue();
            }

            if ($instruction->isUp()) {
                $depth -= $instruction->getValue();
            }
        }

        return new IntegerResult($horizontalPosition * $depth);
    }
}
