<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day2;

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

        /** @var Instruction[] $instructions */
        $instructions = $input->mapLines(
            function (string $instructionLine): Instruction {
                return new Instruction($instructionLine);
            }
        );

        $aim = 0;
        $horizontalPosition = 0;
        $depth = 0;

        foreach ($instructions as $instruction) {
            if ($instruction->isForward()) {
                $horizontalPosition += $instruction->getValue();
                $depth += $instruction->getValue() * $aim;
            }

            if ($instruction->isDown()) {
                $aim += $instruction->getValue();
            }

            if ($instruction->isUp()) {
                $aim -= $instruction->getValue();
            }
        }

        return new IntegerResult($horizontalPosition * $depth);
    }
}
