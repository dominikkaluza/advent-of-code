<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day7;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $pos = explode(',', FileSystem::read(__DIR__ . '/input.txt'));
        $pos = array_map(function ($position): int {
            return (int)$position;
        }, $pos);

        sort($pos);
        $median = $pos[count($pos) / 2];

        $fuel = 0;
        foreach ($pos as $p) {
            $fuel += abs($p - $median);
        }

        return new IntegerResult($fuel);
    }
}
