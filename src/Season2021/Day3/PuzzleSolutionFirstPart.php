<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use AdventOfCode\Season2021\Day2\Instruction;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $gammaBits = [];
        $epsilonBits = [];

        for ($i = 0; $i < 12; $i++) {
            $bits = [];

            foreach ($input->getLines() as $line) {
                $bits[] = substr($line, $i, 1);
            }

            $frequency = array_count_values($bits);
            var_dump($frequency);
            $gammaBits[] = $frequency['1'] > $frequency['0'] ? '1' : '0';
            $epsilonBits[] = $frequency['0'] > $frequency['1'] ? '1' : '0';
        }

        $gammaValue = bindec(implode('', $gammaBits));
        $epsilonValue = bindec(implode('', $epsilonBits));

        return new IntegerResult($gammaValue * $epsilonValue);
    }
}
