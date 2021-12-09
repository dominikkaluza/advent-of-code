<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day8;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $digitPatters = [
            0 => 'abcefg',
            1 => 'cf',
            2 => 'acdeg',
            3 => 'acdfg',
            4 => 'bcdf',
            5 => 'abdfg',
            6 => 'abdefg',
            7 => 'acf',
            8 => 'abcdefg',
            9 => 'abcdfg',
        ];

        $result = 0;
        foreach ($input->getLines() as $line) {
            $parts = explode('|', $line);
            $inputDigits = explode(' ', trim($parts[0]));
            $outputDigits = explode(' ', trim($parts[1]));
            $allDigits = array_merge($inputDigits, $outputDigits);

            $permutations = $this->computePermutations(str_split('abcdefg'));
            foreach ($permutations as $permutation) {
                $pinMap = [
                    'a' => $permutation[0],
                    'b' => $permutation[1],
                    'c' => $permutation[2],
                    'd' => $permutation[3],
                    'e' => $permutation[4],
                    'f' => $permutation[5],
                    'g' => $permutation[6],
                ];

                $validDigits = 0;
                foreach ($allDigits as $digit) {
                    $turnedOnPins = [];
                    for ($d = 0; $d < strlen($digit); $d++) {
                        $turnedOnPins[] = $pinMap[$digit[$d]];
                    }

                    sort($turnedOnPins);
                    $digitPattern = implode('', $turnedOnPins);

                    if (in_array($digitPattern, $digitPatters, true)) {
                        $validDigits++;
                    }
                }

                // correct permutation
                if ($validDigits === count($allDigits)) {
                    $number = '';
                    foreach ($outputDigits as $outputDigit) {
                        $translatedDigit = [];
                        for ($i = 0; $i < strlen($outputDigit); $i++) {
                            $translatedDigit[] = $pinMap[$outputDigit[$i]];
                        }

                        sort($translatedDigit);
                        $finalDigitPattern = implode('', $translatedDigit);
                        $number .= array_search($finalDigitPattern, $digitPatters, true);
                    }
                    $result += (int)$number;
                }
            }
        }

        return new IntegerResult($result);
    }


    private function computePermutations($array)
    {
        $result = [];

        $recurse = function ($array, $start_i = 0) use (&$result, &$recurse) {
            if ($start_i === count($array) - 1) {
                array_push($result, $array);
            }

            for ($i = $start_i; $i < count($array); $i++) {
                //Swap array value at $i and $start_i
                $t = $array[$i];
                $array[$i] = $array[$start_i];
                $array[$start_i] = $t;

                //Recurse
                $recurse($array, $start_i + 1);

                //Restore old order
                $t = $array[$i];
                $array[$i] = $array[$start_i];
                $array[$start_i] = $t;
            }
        };

        $recurse($array);

        return $result;
    }
}
