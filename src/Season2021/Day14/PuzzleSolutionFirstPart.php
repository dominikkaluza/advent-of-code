<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day14;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $lines = (new LinesInput(__DIR__ . '/input.txt'))->getLines();

        $template = $lines[0];
        unset($lines[0], $lines[1]);

        $pairs = [];
        foreach ($lines as $line) {
            $exploded = explode(' -> ', $line);
            $pairs[$exploded[0]] = $exploded[1];
        }

//        echo $template .PHP_EOL;

        for ($step = 0; $step < 10; $step++) {
            $len = strlen($template);
            $newTemplate = $template[0];
            for ($i = 0; $i < $len - 1; $i++) {
                $pair = $template[$i] . $template [$i+1];
                $newTemplate .= $pairs[$pair] . $template[$i +1];
            }

            $template = $newTemplate;
//            echo $template .PHP_EOL;
        }

        $elements = array_count_values(str_split($template));
        asort($elements);

        return new IntegerResult((int)end($elements) - (int)reset($elements));
    }
}
