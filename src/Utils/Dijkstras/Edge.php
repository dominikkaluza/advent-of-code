<?php declare(strict_types = 1);

namespace AdventOfCode\Utils\Dijkstras;

final class Edge
{
    private string $index;

    private int $distance;


    public function __construct(string $index, int $distance)
    {
        $this->index = $index;
        $this->distance = $distance;
    }


    public function getIndex(): string
    {
        return $this->index;
    }


    public function getDistance(): int
    {
        return $this->distance;
    }
}
