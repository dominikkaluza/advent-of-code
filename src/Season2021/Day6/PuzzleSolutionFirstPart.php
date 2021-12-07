<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day6;

use AdventOfCode\IntegerResult;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use AdventOfCode\StringResult;
use LogicException;
use Nette\Utils\FileSystem;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $fishes = explode(',', FileSystem::read(__DIR__ . '/input.txt'));
        $fishes = array_map(function ($fish): int {
            return (int)$fish;
        }, $fishes);

        $days = 80;
        for ($i = 0; $i < $days; $i++) {
            $newFishes = [];
            for ($j = 0; $j < count($fishes); $j++) {
                if ($fishes[$j] === 0) {
                    $newFishes[] = 8;
                    $fishes[$j] = 6;

                    continue;
                }

                $fishes[$j]--;
            }

            foreach ($newFishes as $newFish) {
                $fishes[] = $newFish;
            }
        }

        return new IntegerResult(count($fishes));
    }
}
