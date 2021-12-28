<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day15;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use AdventOfCode\Utils\Dijkstras\Dijkstras;
use AdventOfCode\Utils\Dijkstras\Edge;
use AdventOfCode\Utils\Dijkstras\Graph;
use AdventOfCode\Utils\Dijkstras\Vertex;
use AdventOfCode\Utils\MatrixCost;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    private const ADJACENT = [
        [1, 0],
        [0, -1],
        [-1, 0],
        [0, 1],
    ];


    public function getResult(): Result
    {
        $lines = (new LinesInput(__DIR__ . '/testInput.txt'))->getLines();

        $gridSize = count($lines);
        $grid = [];
        foreach ($lines as $line) {
            $grid[] = array_map('intval', str_split($line));
        }

        $graph = new Graph();
        for ($row = 0; $row < $gridSize; $row++) {
            for ($col = 0; $col < $gridSize; $col++) {
                $newVertex = new Vertex("$row:$col");

                foreach (self::ADJACENT as $adjacent) {
                    $neighbourRow = $row + $adjacent[0];
                    $neighbourCol = $col + $adjacent[1];
                    if (isset($grid[$neighbourRow][$neighbourCol])) {
                        $newVertex->addNeighbour(new Vertex("$neighbourRow:$neighbourCol"));
                        $graph->addEdge(
                            new Edge(
                                "$row:$col-$neighbourRow:$neighbourCol",
                                $grid[$neighbourRow][$neighbourCol]
                            )
                        );
                    }
                }

                $graph->addVertex($newVertex);
            }
        }

        $lastPos = $gridSize - 1;

        $dijkstras = new Dijkstras();
        $cost = $dijkstras->calculateShortestPathCost($graph, $graph->getVertexByIndex("0:0"), $graph->getVertexByIndex("$lastPos:$lastPos"));

        return new IntegerResult($cost);
    }
}
