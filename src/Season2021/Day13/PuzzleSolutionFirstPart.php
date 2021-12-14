<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day13;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use Nette\Utils\Strings;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private $dots = [];

    private $rows;

    private $columns;


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt', "\n\n");
        $dots = explode("\n", $input->getLines()[0]);
        $folds = explode("\n", $input->getLines()[1]);

        $this->rows = 0;
        $this->columns = 0;
        foreach ($dots as $dot) {
            $coords = explode(',', $dot);
            $this->dots[-$coords[1]][$coords[0]] = true;

            if ($coords[0] > $this->columns) {
                $this->columns = $coords[0];
            }

            if ($coords[1] > $this->rows) {
                $this->rows = $coords[1];
            }
        }

        foreach ($folds as $fold) {
            $this->fold($fold);

            break;
        }

        $count = 0;
        for ($y = 0; $y <= $this->rows; $y++) {
            for ($x = 0; $x <= $this->columns; $x++) {
                if (isset($this->dots[-$y][$x])) {
                    $count++;
                }
            }
        }

        return new IntegerResult($count);
    }


    private function fold(string $foldInstruction)
    {
        if (Strings::contains($foldInstruction, "fold along y=")) {
            $coord = str_replace("fold along y=", '', $foldInstruction);
            // horizontal

            for ($y = $coord + 1; $y <= $this->rows; $y++) {
                for ($x = 0; $x <= $this->columns; $x++) {
                    if (isset($this->dots[-$y][$x])) {
                        $newY = $y - 2 * $coord;
                        $this->dots[$newY][$x] = true;
                        unset($this->dots[-$y][$x]);
                    }
                }
            }

            $this->rows = $this->rows / 2 - 1;

            return;
        }

        $coord = str_replace("fold along x=", '', $foldInstruction);
        // vertical
//        var_dump($coord);

        for ($y = 0; $y <= $this->rows; $y++) {
            for ($x = $coord + 1; $x <= $this->columns; $x++) {
                if (isset($this->dots[-$y][$x])) {
                    $newX = $x - 2 * $coord;
                    $this->dots[-$y][-$newX] = true;
                    unset($this->dots[-$y][$x]);
                }
            }
        }

        $this->columns = $this->columns / 2 - 1;
    }
}
