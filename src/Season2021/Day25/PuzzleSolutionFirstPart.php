<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day25;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = (new LinesInput(__DIR__ . '/input.txt'))->mapLines(function ($line) {
            return str_split($line);
        });

        $changed = true;
        $steps = 0;
        $rowCount = count($input);
        $colCount = count($input[0]);

        foreach ($input as $line) {
            echo implode('', $line) . PHP_EOL;
        }
        echo PHP_EOL;

        while ($changed) {
            $newGrid = $input;
            $changed = false;

            for ($i = 0; $i < $rowCount; $i++) {
                for ($j = 0; $j < $colCount; $j++) {
                    if ($input[$i][$j] === '>') {
                        $newJ = isset($input[$i][$j + 1]) ? $j + 1 : 0;
                        if ($input[$i][$newJ] === '.') {
                            $newGrid[$i][$newJ] = '>';
                            $newGrid[$i][$j] = '.';
                            $changed = true;
                        }
                    }
                }
            }

            $input = $newGrid;
            for ($i = 0; $i < $rowCount; $i++) {
                for ($j = 0; $j < $colCount; $j++) {
                    if ($input[$i][$j] === 'v') {
                        $newI = isset($input[$i + 1][$j]) ? $i + 1 : 0;

                        if ($input[$newI][$j] === '.') {
                            $newGrid[$newI][$j] = 'v';
                            $newGrid[$i][$j] = '.';
                            $changed = true;
                        }
                    }
                }
            }

            $input = $newGrid;

            $steps++;
//            var_dump($steps);
            foreach ($input as $line) {
                echo implode('', $line) . PHP_EOL;
            }
            echo PHP_EOL;
        }

        return new IntegerResult($steps);
    }
}
