<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day5;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use LogicException;

final class PuzzleSolutionSecondPart implements PuzzleSolution
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
        $hasDoublePair = false;
        $hasRepeatedLetterWithASpace = false;
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === ($string[$i + 2] ?? '')) {
                $hasRepeatedLetterWithASpace = true;
            }

            $pair = $string[$i] . ($string[$i + 1] ?? 'last-invalid');

            $firstIndex = strpos($string, $pair);
            $lastIndex = strrpos($string, $pair);

            if($firstIndex !== false && $lastIndex !== false && $lastIndex - $firstIndex > 1) {
                $hasDoublePair = true;
            }
        }


        return $hasDoublePair && $hasRepeatedLetterWithASpace;
    }
}
