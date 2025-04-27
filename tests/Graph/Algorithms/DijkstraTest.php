<?php

namespace GraphTests\Graph\Algorithms;

use Graph\Algorithms\Dijkstra;
use Graph\GraphAbstract;
use Graph\Representations\AdjacencyListImmutable;
use Graph\Representations\Edges;
use Graph\Representations\Nodes;
use PHPUnit\Framework\TestCase;

class DijkstraTest extends TestCase
{
    private $adjacencyList;
    public function setUp(): void
    {
        $nodesArray = ['A', 'B', 'C', 'D', 'E'];
        $adjacencyList = new AdjacencyListImmutable();
        $nodes = new Nodes();
        $edges = new Edges();
        foreach ($nodesArray as $nodeName) {
            $nodes->add($nodeName);
        }
        $edges->addEdge('A', 'B', 1);
        $edges->addEdge('B', 'C', 2);
        $edges->addEdge('C', 'A', 3);
        $this->adjacencyList = $adjacencyList->setNodes($nodes)->setEdges($edges);
    }

    public function testDijkstraArrayImpl()
    {
        $dijkstra = new Dijkstra()->dijkstraArrayImpl($this->adjacencyList, 'A');
        $weights = [];
        while ($dijkstra->valid()) {
            $weights[] = $dijkstra->current();
            $dijkstra->next();
        }
        $this->assertSame([['B' => 1], ['C' => 3]], $weights);
    }

    public function testDijkstraPriorityQueue()
    {
        $dijkstra = new Dijkstra()->dijkstraPriorityQueue($this->adjacencyList, 'A');
        $weights = [];
        while ($dijkstra->valid()) {
            $weights[] = $dijkstra->current();
            $dijkstra->next();
        }
        $this->assertSame([['B' => 1], ['C' => 3]], $weights);
    }
}
