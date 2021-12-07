<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day6;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        /** @var Instruction[] $instructions */
        $instructions = LinesInput::createAsObjects(__DIR__ . '/input.txt', Instruction::class);

        $lights = [];
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                $lights[$i][$j] = false;
            }
        }

        foreach ($instructions as $instruction) {
            for ($x = $instruction->getX1(); $x <= $instruction->getX2(); $x++) {
                for ($y = $instruction->getY1(); $y <= $instruction->getY2(); $y++) {
                    switch ($instruction->getType()) {
                        case Instruction::TURN_ON:
                            $lights[$x][$y] = true;
                            break;
                        case Instruction::TURN_OFF:
                            $lights[$x][$y] = false;
                            break;
                        case Instruction::TOGGLE:
                            $lights[$x][$y] = !$lights[$x][$y];
                            break;
                    }
                }
            }
        }

        $turnedOn = 0;
        foreach ($lights as $lightRow) {
            $turnedOn += count(
                array_filter($lightRow, function (bool $light): bool {
                    return $light === true;
                })
            );
        }

        return new IntegerResult($turnedOn);
    }
}
