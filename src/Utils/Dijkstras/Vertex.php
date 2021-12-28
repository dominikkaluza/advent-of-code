<?php declare(strict_types = 1);

namespace AdventOfCode\Utils\Dijkstras;

final class Vertex
{
    private string $index;

    private array $neighbours = [];


    public function __construct(string $index)
    {
        $this->index = $index;
    }


    public function getIndex(): string
    {
        return $this->index;
    }


    /**
     * @return Vertex[]
     */
    public function getNeighbours(): array
    {
        return $this->neighbours;
    }


    public function addNeighbour(Vertex $vertex): void
    {
        $this->neighbours[] = $vertex;
    }
}
