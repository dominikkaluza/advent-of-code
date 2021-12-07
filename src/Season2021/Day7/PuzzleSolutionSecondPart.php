<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day7;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $pos = explode(',', FileSystem::read(__DIR__ . '/input.txt'));
        $pos = array_map(function ($position): int {
            return (int)$position;
        }, $pos);

        sort($pos);
        $mean = (int)round(array_sum($pos) / count($pos)) - 1; // Rounded mean is not foolproof, so try surrounding values (+0, -1, +1)
        var_dump($mean);
        var_dump(array_sum($pos) / count($pos));

        $fuel = 0;
        foreach ($pos as $p) {
            $fuelStep = 1;
            $abs = abs($p - $mean);
            for ($i = 1; $i <= $abs; $i++) {
                $fuel += $fuelStep;
                $fuelStep++;
            }
        }

        return new IntegerResult($fuel);
    }
}
