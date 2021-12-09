<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day9;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    private $grid = [];


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        foreach ($input->getLines() as $line) {
            $this->grid[] = array_map('intval', str_split($line));
        }

        $rows = count($this->grid);
        $columns = count($this->grid[0]);

        $basins = [];
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $isLowPoint = $this->isLowPoint($i, $j);

                if ($isLowPoint) {
                    $basins[] = count($this->getBasinSize($i, $j));
                }
            }
        }

        rsort($basins);

        return new IntegerResult($basins[0] * $basins[1] * $basins[2]);
    }


    private function getBasinSize(int $i, int $j, &$counted = [])
    {
        $counted[] = "$i:$j";
        echo "getting for $i:$j\n";
        $adjacentPointsDeltas = [[1, 0], [-1, 0], [0, 1], [0, -1]];
        foreach ($adjacentPointsDeltas as $adjacentPointsDelta) {
            $pointString = ($i + $adjacentPointsDelta[0]) . ':' . ($j + $adjacentPointsDelta[1]);
            $exists = isset($this->grid[$i + $adjacentPointsDelta[0]][$j + $adjacentPointsDelta[1]]);
            $isNotHighPoint = $exists && $this->grid[$i + $adjacentPointsDelta[0]][$j + $adjacentPointsDelta[1]] < 9;
            $isNotCounted = !in_array($pointString, $counted, true);
            echo $pointString, ' ', $exists ? 'exists ' : 'notExists ', $isNotHighPoint ? 'notHigh ' : 'high ', $isNotCounted ? 'notCounted ' : 'counted ', $isNotHighPoint && $isNotCounted ? 'pushed ' : 'notPushed', PHP_EOL;
            if ($isNotHighPoint && $isNotCounted) {
                echo "counted $pointString\n";
                $this->getBasinSize($i + $adjacentPointsDelta[0], $j + $adjacentPointsDelta[1], $counted);
            }
        }

        return $counted;
    }


    private function isLowPoint(int $i, int $j): bool
    {
        $isLowPoint = true;
        $adjacentPointsDeltas = [[1, 0], [-1, 0], [0, 1], [0, -1]];
        foreach ($adjacentPointsDeltas as $adjacentPointsDelta) {
            if (isset($this->grid[$i + $adjacentPointsDelta[0]][$j + $adjacentPointsDelta[1]])
                && $this->grid[$i][$j] >= $this->grid[$i + $adjacentPointsDelta[0]][$j + $adjacentPointsDelta[1]]) {
                $isLowPoint = false;
            }
        }

        return $isLowPoint;
    }
}
