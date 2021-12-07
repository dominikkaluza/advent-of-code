<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day3;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    private const LENGTH = 12;


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $lines = $input->getLines();
        $oxygenGeneratorRating = 0;
        for ($i = 0; $i < self::LENGTH; $i++) {
            $gammaBit = $this->getGammaBit($lines, $i);

            $lines = array_filter($lines, function ($line) use ($i, $gammaBit): bool {
                return substr($line, $i, 1) !== $gammaBit;
            });

            if (count($lines) === 1) {
                $oxygenGeneratorRating = bindec(reset($lines));

                break;
            }
        }

        $lines = $input->getLines();
        $co2ScrubberRating = 0;
        for ($i = 0; $i < self::LENGTH; $i++) {
            $epsilonBit = $this->getEpsilonBit($lines, $i);

            $lines = array_filter($lines, function ($line) use ($i, $epsilonBit): bool {
                return substr($line, $i, 1) !== $epsilonBit;
            });

            if (count($lines) === 1) {
                $co2ScrubberRating = bindec(reset($lines));

                break;
            }
        }

        return new IntegerResult($oxygenGeneratorRating * $co2ScrubberRating);
    }


    private function getGammaBit($lines, $index): string
    {
        $bits = [];
        foreach ($lines as $line) {
            $bits[] = substr($line, $index, 1);
        }

        $frequency = array_count_values($bits);

        return $frequency['1'] >= $frequency['0'] ? '1' : '0';
    }


    private function getEpsilonBit($lines, $index): string
    {
        $bits = [];
        foreach ($lines as $line) {
            $bits[] = substr($line, $index, 1);
        }

        $frequency = array_count_values($bits);

        return $frequency['0'] > $frequency['1'] ? '1' : '0';
    }
}
