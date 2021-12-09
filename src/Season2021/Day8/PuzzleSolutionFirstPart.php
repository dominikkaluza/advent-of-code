<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day8;

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

		$allowedDigits = [3, 2, 4, 7];

		$count = 0;
		foreach ($input->getLines() as $line) {
		    $secondPart = trim(explode('|', $line)[1]);
            $digits = explode(' ', $secondPart);

            foreach ($digits as $digit) {
                var_dump($digit);
                if(in_array(strlen($digit), $allowedDigits, true)) {
                    $count++;
                }
            }
        }

		return new IntegerResult($count);
    }
}
