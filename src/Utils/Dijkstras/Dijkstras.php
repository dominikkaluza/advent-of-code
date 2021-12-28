<?php declare(strict_types = 1);

namespace AdventOfCode\Utils\Dijkstras;

use PriorityQueue;

final class Dijkstras
{
    private $dist = [];

    private $prev = [];


    /**
     * 1 function Dijkstra(Graph, source):
     * 2
     * 3      create vertex set Q
     * 4
     * 5      for each vertex v in Graph:
     * 6          dist[v] ← INFINITY
     * 7          prev[v] ← UNDEFINED
     * 8          add v to Q
     * 9      dist[source] ← 0
     * 10
     * 11      while Q is not empty:
     * 12          u ← vertex in Q with min dist[u]
     * 13
     * 14          remove u from Q
     * 15
     * 16          for each neighbor v of u still in Q:
     * 17              alt ← dist[u] + length(u, v)
     * 18              if alt < dist[v]:
     * 19                  dist[v] ← alt
     * 20                  prev[v] ← u
     * 21
     * 22      return dist[], prev[]
     */
    public function calculateShortestPathCost(Graph $graph, Vertex $start, Vertex $end = null): int
    {
        $this->dist[$start->getIndex()] = 0;

        $Q = new PriorityQueue();

        foreach ($graph->getVertices() as $v) {
            if($v->getIndex() !== $start->getIndex()){
                $this->dist[$v->getIndex()] = PHP_INT_MAX;
                $this->prev[$v->getIndex()] = null;
            }

            $Q->push($v->getIndex(), $this->dist[$v->getIndex()]);
        }


        while (!$Q->isEmpty()) {
            $u = $graph->getVertexByIndex($Q->pop());

            foreach ($u->getNeighbours() as $v) {
                if(!$Q->contains($v->getIndex())) {
                    continue;
                }

                $alt = $this->dist[$u->getIndex()]
                    + $graph->getEdgeByIndex("{$u->getIndex()}-{$v->getIndex()}")->getDistance();

                if($alt < $this->dist[$v->getIndex()]) {
                    $this->dist[$v->getIndex()] = $alt;
                    $this->prev[$v->getIndex()] = $u;
                    $Q->change_priority($v->getIndex(), $alt);
                }
            }
        }

        return $this->dist[$end->getIndex()];
    }
}
