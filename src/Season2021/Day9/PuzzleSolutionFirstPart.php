<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day9;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{

    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $grid = [];
        foreach ($input->getLines() as $line) {
            $grid[] = array_map('intval', str_split($line));
        }

        $riskLevel = 0;
        $rows = count($grid);
        $columns = count($grid[0]);

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $adjacentPointsDeltas = [[1, 0], [-1, 0], [0, 1], [0, -1]];
                $isLowPoint = true;
                foreach ($adjacentPointsDeltas as $adjacentPointsDelta) {
                    if (isset($grid[$i + $adjacentPointsDelta[0]][$j + $adjacentPointsDelta[1]])
                        && $grid[$i][$j] >= $grid[$i + $adjacentPointsDelta[0]][$j + $adjacentPointsDelta[1]]) {
                        $isLowPoint = false;
                    }
                }

                if($isLowPoint) {
                    $riskLevel += 1 + $grid[$i][$j];
                }
            }
        }

        return new IntegerResult($riskLevel);
    }
}
