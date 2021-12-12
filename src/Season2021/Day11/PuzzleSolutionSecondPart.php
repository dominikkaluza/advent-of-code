<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day11;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    const GRID_SIZE = 10;
    const STEPS = 100000000;

    private $grid = [];

    private $flashes = 0;

    private const ADJACENT = [
        [1, 1],
        [1, 0],
        [1, -1],
        [0, -1],
        [-1, -1],
        [-1, 0],
        [-1, 1],
        [0, 1],
    ];

    private $flashed = [];


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $this->grid = [];
        foreach ($input->getLines() as $line) {
            $this->grid[] = str_split($line);
        }

        for ($steps = 0; $steps < self::STEPS; $steps++) {
            $this->flashed = [];

            for ($i = 0; $i < self::GRID_SIZE; $i++) {
                for ($j = 0; $j < self::GRID_SIZE; $j++) {
                    $this->grid[$i][$j]++;
                }
            }

            for ($i = 0; $i < self::GRID_SIZE; $i++) {
                for ($j = 0; $j < self::GRID_SIZE; $j++) {
                    $this->tryFlash($i, $j);
                }
            }

            for ($i = 0; $i < self::GRID_SIZE; $i++) {
                for ($j = 0; $j < self::GRID_SIZE; $j++) {
                    if ($this->grid[$i][$j] > 9) {
                        $this->grid[$i][$j] = 0;
                    }
                }
            }

            // if all flash at the same time
            $flashCount = 0;
            for ($i = 0; $i < self::GRID_SIZE; $i++) {
                for ($j = 0; $j < self::GRID_SIZE; $j++) {
                    if($this->grid[$i][$j] === 0) {
                        $flashCount++;
                    }
                }
            }

            if($flashCount === 100) {
                return new IntegerResult($steps + 1);
            }
        }

        return new IntegerResult(0);
    }


    private function tryFlash(int $x, int $y)
    {
        if ($this->grid[$x][$y] > 9 && !isset($this->flashed[$x][$y])) {
            $this->flashes++;
            $this->flashed[$x][$y] = true;

            foreach (self::ADJACENT as $adjacent) {
                if (!isset($this->grid[$x + $adjacent[0]][$y + $adjacent[1]])) {
                    continue;
                }

                $this->grid[$x + $adjacent[0]][$y + $adjacent[1]]++;
                $this->tryFlash($x + $adjacent[0], $y + $adjacent[1]);
            }
        }
    }
}
