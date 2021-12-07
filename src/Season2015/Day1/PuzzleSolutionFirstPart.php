<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day1;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = FileSystem::read(__DIR__ . '/input.txt');

        $up = substr_count($input, '(');
        $down = substr_count($input, ')');

        return new IntegerResult($up - $down);
    }
}
