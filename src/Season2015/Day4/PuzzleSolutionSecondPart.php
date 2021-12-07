<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day4;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = 'ckczppom';

        $i = 1;
        while (substr(md5($input . $i), 0, 6) !== '000000') {
            $i++;
        }

        return new IntegerResult($i);
    }
}
