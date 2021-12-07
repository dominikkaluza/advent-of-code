<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day5;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $niceStrings = 0;
        foreach ($input->getLines() as $string) {
            if($this->isNice($string)) {
                $niceStrings++;
            }
        }

        return new IntegerResult($niceStrings);
    }


        private function isNice(string $string): bool
        {
            $vowels = ['a', 'e', 'i', 'o', 'u'];

            $vowelCount = 0;
            $lettersInARow = false;
            $doesNotContainBadStrings = true;
            for ($i = 0; $i < strlen($string); $i++) {
                if (in_array($string[$i], $vowels, true)) {
                    $vowelCount++;
                }

                if ($string[$i] === ($string[$i + 1] ?? '')) {
                    $lettersInARow = true;
                }
            }

            foreach (['ab', 'cd', 'pq', 'xy'] as $badString) {
                if (str_contains($string, $badString)) {
                    $doesNotContainBadStrings = false;
                }
            }

            return $vowelCount >= 3 && $lettersInARow && $doesNotContainBadStrings;
        }
}
