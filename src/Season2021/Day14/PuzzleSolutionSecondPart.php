<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day14;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $lines = (new LinesInput(__DIR__ . '/input.txt'))->getLines();

        $template = $lines[0];
        unset($lines[0], $lines[1]);

        $pairInsertions = [];
        foreach ($lines as $line) {
            $exploded = explode(' -> ', $line);
            $pairInsertions[$exploded[0]] = $exploded[1];
        }

        $pairsCount = [];
        $len = strlen($template);
        for ($i = 0; $i < $len - 1; $i++) {
            if (!isset($pairsCount[$template[$i] . $template [$i + 1]])) {
                $pairsCount[$template[$i] . $template [$i + 1]] = 0;
            }

            $pairsCount[$template[$i] . $template [$i + 1]]++;
        }



        $letterCount = array_count_values(str_split($template));

        for ($step = 0; $step < 40; $step++) {
            $newPairsCount = $pairsCount;

            foreach ($pairsCount as $pair => $pairCount) {
                $pairInsertion = $pairInsertions[$pair];
                if (!isset($newPairsCount[$pair[0] . $pairInsertion])) {
                    $newPairsCount[$pair[0] . $pairInsertion] = 0;
                }
                if (!isset($newPairsCount[$pairInsertion . $pair[1]])) {
                    $newPairsCount[$pairInsertion . $pair[1]] = 0;
                }
                $newPairsCount[$pair[0] . $pairInsertion] += $pairCount;
                $newPairsCount[$pairInsertion . $pair[1]] += $pairCount;
                $newPairsCount[$pair] -= $pairCount;

                $letterCount[$pairInsertion] += $pairCount;
            }

            $pairsCount = $newPairsCount;
        }

        asort($letterCount);
        var_dump($letterCount);

        return new IntegerResult((int)end($letterCount) - (int)reset($letterCount));
    }
}
