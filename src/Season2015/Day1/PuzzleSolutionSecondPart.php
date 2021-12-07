<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use Exception;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = FileSystem::read(__DIR__ . '/input.txt');

//        $input = '()())((((';

        for ($i = 0; $i < strlen($input); $i++) {
            $up = substr_count($input, '(', 0, $i);
            $down = substr_count($input, ')', 0, $i);

            if($up < $down) {
                return new IntegerResult($i);
            }
        }

        throw new Exception('error');
    }
}
