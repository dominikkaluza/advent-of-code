<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day10;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $opening = ['{', '[', '<', '('];
        $map = [
            '}' => '{',
            ']' => '[',
            '>' => '<',
            ')' => '(',
        ];
        $incompleteMap = [
            '{' => '}',
            '[' => ']',
            '<' => '>',
            '(' => ')',
        ];

        $incomplete = [];
        foreach ($input->getLines() as $line) {
            $queue = new \SplQueue();

            $split = str_split($line);

            foreach ($split as $character) {
                if (in_array($character, $opening, true)) {
                    $queue->push($character);
                } else {
                    if ($map[$character] !== $queue->pop()) {
                        continue 2;
                    }
                }
            }

            $incomplete[] = $line;
        }

        $scoreMap = [
            ')' => 1,
            ']' => 2,
            '}' => 3,
            '>' => 4,
        ];
        $scores = [];
        foreach ($incomplete as $line) {
            while (preg_match("/({}|\(\)|\[]|<>)/i", $line)) {
                $line = str_replace(['{}', '()', '[]', '<>'], '', $line);
            }

            $split = str_split($line);
            $split = array_map(function ($char) use ($incompleteMap): string {
                return $incompleteMap[$char];
            }, $split);

            $autocomplete = array_reverse($split);

            $score = 0;
            foreach ($autocomplete as $char) {
                $score *= 5;
                $score += $scoreMap[$char];
            }
            $scores[] = $score;
        }

        sort($scores);
        $middleScore = round(count($scores) / 2, 0, PHP_ROUND_HALF_DOWN);

        return new IntegerResult($scores[$middleScore]);
    }
}
