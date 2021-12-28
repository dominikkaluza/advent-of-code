<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day21;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $player1Pos = (int)str_replace('Player 1 starting position: ', '', $input->getLines()[0]);
        $player2Pos = (int)str_replace('Player 2 starting position: ', '', $input->getLines()[1]);

        $player1Score = 0;
        $player2Score = 0;

        $player = 1;
        $dice = 1;
        $diceRolls = 0;

        while ($player1Score < 1000 && $player2Score < 1000) {
            $roll = 0;
            for ($i = 0; $i < 3; $i++) {
                $roll += $dice++;
                $diceRolls++;
            }

            if ($player === 1) {
                $player1Pos = ($player1Pos + $roll) % 10;
                $player1Pos = $player1Pos === 0 ? 10 : $player1Pos;
                $player1Score += $player1Pos;
                $player = 2;
            } else {
                $player2Pos = ($player2Pos + $roll) % 10;
                $player2Pos = $player2Pos === 0 ? 10 : $player2Pos;
                $player2Score += $player2Pos;
                $player = 1;
            }
        }

        return new IntegerResult(min($player1Score, $player2Score) * $diceRolls);
    }
}
