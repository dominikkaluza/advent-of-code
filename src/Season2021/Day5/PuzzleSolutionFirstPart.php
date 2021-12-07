<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day5;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use AdventOfCode\Season2021\Day2\Instruction;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        /** @var Line[] $lines */
        $lines = $input->mapLines(
            function (string $line): Line {
                return new Line($line);
            }
        );

        $lines = array_filter($lines, function (Line $line): bool {
            return $line->isHorizontalOrVertical();
        });

        $points = [];
        foreach ($lines as $line) {
            foreach ($line->getPoints() as $point) {
                if (!isset($points[$point->getX()][$point->getY()])) {
                    $points[$point->getX()][$point->getY()] = 0;
                }

                $points[$point->getX()][$point->getY()]++;
            }
        }

//        for($i = 0; $i <= 9; $i++) {
//            for($j = 0; $j <= 9; $j++) {
//                echo $points[$i][$j] ?? '.';
//            }
//            echo PHP_EOL;
//        }



        $count = 0;
        for($i = 0; $i <= 999; $i++) {
            for($j = 0; $j <= 999; $j++) {
                if(isset($points[$i][$j]) && $points[$i][$j] > 1) {
                    $count++;
                }
            }
        }


//        for($i = 0; $i < 9; $i++) {
//            for($j = 0; $j < 9; $j++) {
//                echo $points[$i][$j] ?? '.';
//            }
//            echo PHP_EOL;
//        }

        return new IntegerResult($count);
    }
}
