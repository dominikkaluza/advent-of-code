<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day10;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/testInput.txt');


        $opening = ['{', '[', '<', '('];
        $closing = ['}', ']', '>', ')'];
        $map = [
            '}' => '{',
            ']' => '[',
            '>' => '<',
            ')' => '(',
        ];
        $scoreMap = [
            ')' => 3,
            ']' => 57,
            '}' => 1197,
            '>' => 25137,
        ];

        $score = 0;
        foreach ($input->getLines() as $line) {
            $queue = new \SplQueue();
            $split = str_split($line);

            foreach ($split as $character) {
                if (in_array($character, $opening, true)) {
                    $queue->push($character);
                } else {
                    if ($map[$character] !== $queue->pop()) {
                        $score += $scoreMap[$character];
                        continue 2;
                    }
                }
            }
        }

        return new IntegerResult($score);
    }
}
