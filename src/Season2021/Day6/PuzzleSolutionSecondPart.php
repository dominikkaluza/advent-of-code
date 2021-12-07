<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day6;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use AdventOfCode\StringResult;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $fishes = explode(',', FileSystem::read(__DIR__ . '/input.txt'));
        $fishes = array_map(function ($fish): int {
            return (int)$fish;
        }, $fishes);

        $fishCounts = array_count_values($fishes);
        $fishCounts[6] = 0;
        $fishCounts[7] = 0;
        $fishCounts[8] = 0;

        $days = 256;
        for ($i = 0; $i < $days; $i++) {
            $zeroDayFishes = $fishCounts[0];

            for ($j = 1; $j <= 8; $j++) {
                $fishCounts[$j - 1] = $fishCounts[$j];
            }

            $fishCounts[6] += $zeroDayFishes;
            $fishCounts[8] = $zeroDayFishes;
        }

        $count = 0;
        foreach ($fishCounts as $fishCount) {
            $count += $fishCount;
        }
        return new IntegerResult($count);
    }
}
