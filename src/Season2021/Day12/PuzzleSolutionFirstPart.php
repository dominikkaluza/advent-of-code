<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day12;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private $caves = [];


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        foreach ($input->getLines() as $line) {
            $parts = explode('-', $line);
            $this->caves[$parts[0]] = array_merge($this->caves[$parts[0]] ?? [], [$parts[1]]);
            $this->caves[$parts[1]] = array_merge($this->caves[$parts[1]] ?? [], [$parts[0]]);
        }

        return new IntegerResult($this->getPathNumber('start', []));
    }


    private function getPathNumber(string $index, array $seen): int
    {
        if ($index === 'end') {
            return 1;
        }

        if ($index === strtolower($index) && in_array($index, $seen)) {
            return 0;
        }

        $seen[] = $index;

        $paths = 0;
        foreach ($this->caves[$index] as $neigh) {
            $paths += $this->getPathNumber($neigh, $seen);
        }

        return $paths;
    }
}
