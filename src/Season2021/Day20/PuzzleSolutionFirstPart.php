<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day20;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const DELTAS = [
        [-1, -1],
        [-1, 0],
        [-1, 1],
        [0, -1],
        [0, 0],
        [0, 1],
        [1, -1],
        [1, 0],
        [1, 1],
    ];


    public function getResult(): Result
    {
        // doesnt work for test input because of alternating background
        $lines = (new LinesInput(__DIR__ . '/input.txt'))->getLines();

        $algo = array_shift($lines);
        array_shift($lines);

        $image = [];
        foreach ($lines as $line) {
            $image[] = str_split($line);
        }

        $image = $this->enhance($image, $algo, '.');
        $image = $this->enhance($image, $algo, '#');

        $lightPixels = 0;
        $size = count($image);
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if (($image[$i][$j]) === '#') {
                    $lightPixels++;
                }
            }
        }

        return new IntegerResult($lightPixels);
    }


    private function enhance(array $image, string $algo, string $background): array
    {
        $enhanced = [];

        $size = count($image);

        $offset = 1;

        for ($i = -$offset; $i < $size + $offset; $i++) {
            for ($j = -$offset; $j < $size + $offset; $j++) {
                $bin = '';
                foreach (self::DELTAS as $delta) {
                    $pixel = $image[$i + $delta[0]][$j + $delta[1]] ?? $background;
                    $bin .= $pixel === '#' ? 1 : 0;
                }
                $dec = bindec($bin);

                $enhanced[$i + $offset][$j + $offset] = $algo[$dec];
            }
        }

        return $enhanced;
    }
}
