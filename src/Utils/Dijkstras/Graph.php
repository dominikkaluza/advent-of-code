<?php declare(strict_types = 1);

namespace AdventOfCode\Utils\Dijkstras;

final class Graph
{
    private array $edges = [];

    private array $vertices = [];


    /**
     * @return Edge[]
     */
    public function getEdges(): array
    {
        return $this->edges;
    }


    /**
     * @return Vertex[]
     */
    public function getVertices(): array
    {
        return $this->vertices;
    }


    public function getVertexByIndex($index): Vertex
    {
        return $this->vertices[$index];
    }


    public function getEdgeByIndex(string $index): Edge
    {
        return $this->edges[$index];
    }


    public function addVertex(Vertex $vertex): void
    {
        $this->vertices[$vertex->getIndex()] = $vertex;
    }


    public function addEdge(Edge $edge): void
    {
        $this->edges[$edge->getIndex()] = $edge;
    }
}
