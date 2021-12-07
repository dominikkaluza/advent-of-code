<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day6;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        /** @var Instruction[] $instructions */
        $instructions = LinesInput::createAsObjects(__DIR__ . '/input.txt', Instruction::class);

        $lights = [];
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                $lights[$i][$j] = 0;
            }
        }

        foreach ($instructions as $instruction) {
            for ($x = $instruction->getX1(); $x <= $instruction->getX2(); $x++) {
                for ($y = $instruction->getY1(); $y <= $instruction->getY2(); $y++) {
                    switch ($instruction->getType()) {
                        case Instruction::TURN_ON:
                            $lights[$x][$y]++;
                            break;
                        case Instruction::TURN_OFF:
                            $lights[$x][$y] === 0 ? $lights[$x][$y] = 0 : $lights[$x][$y]--;
                            break;
                        case Instruction::TOGGLE:
                            $lights[$x][$y] += 2;
                            break;
                    }
                }
            }
        }

        $brightness = 0;
        foreach ($lights as $lightRow) {
            $brightness += array_sum($lightRow);
        }

        return new IntegerResult($brightness);
    }
}
