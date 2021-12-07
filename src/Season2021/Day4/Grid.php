<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day4;

use AdventOfCode\LinesInput;
use function str_split;

final class Grid
{
    /**
     * @var Number[][]
     */
    private $grid;


    public function __construct(string $inputString)
    {
        $lines = explode(PHP_EOL, $inputString);

        foreach ($lines as $i => $line) {
            $line = trim(str_replace('  ', ' ', $line));
            echo $line . PHP_EOL;
            $numbers = explode(' ', $line);
            var_dump($numbers);

            foreach ($numbers as $j => $number) {
                $this->grid[$i][$j] = new Number($number);
            }
        }

        $vis = '';

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $vis .= str_pad($this->grid[$i][$j]->getNumber(), 2, ' ', STR_PAD_LEFT) . ' ';
            }

            $vis .= PHP_EOL;
        }

        echo PHP_EOL . $vis . PHP_EOL;
    }


    public function markNumber(string $number): void
    {
        $vis = '';

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $gridNumber = $this->grid[$i][$j];

                if ($gridNumber->getNumber() === $number) {
                    $gridNumber->mark();
                }

                $vis .= str_pad($gridNumber->getNumber(), 2, ' ', STR_PAD_LEFT) . ($gridNumber->isMarked(
                    ) ? 'x' : '') . ' ';
            }

            $vis .= PHP_EOL;
        }
//        echo $vis . PHP_EOL;
    }


    public function getChar(int $y, int $x): Number
    {
        return $this->grid[$y][$x];
    }


    public function hasWon(): bool
    {
        for ($i = 0; $i < 5; $i++) {
            $rowMarked = true;
            $columnMarked = true;

            for ($j = 0; $j < 5; $j++) {
                $rowGridNumber = $this->grid[$i][$j];
                $columnGridNumber = $this->grid[$j][$i];

                if (!$rowGridNumber->isMarked()) {
                    $rowMarked = false;
                }
                if (!$columnGridNumber->isMarked()) {
                    $columnMarked = false;
                }
            }

            if ($rowMarked === true) {
                var_dump("ROW: " . $i);

                return true;
            }

            if ($columnMarked === true) {
                var_dump("COLUMN: " . $j);

                return true;
            }
        }

        return false;
    }


    public function getScore(string $drawnNumber): int
    {
        $sum = 0;

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $gridNumber = $this->grid[$i][$j];

                if (!$gridNumber->isMarked()) {
                    $sum += (int)$gridNumber->getNumber();
                }
            }
        }

        return (int)$drawnNumber * $sum;
    }
}
