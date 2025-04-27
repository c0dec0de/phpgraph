<?php

namespace GraphTests\Graph\Algorithms;

use Graph\Algorithms\WFI;
use Graph\Representations\AdjacencyListImmutable;
use Graph\Representations\Edges;
use Graph\Representations\Nodes;
use PHPUnit\Framework\TestCase;

class WFITest extends TestCase
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

    public function testWfi()
    {
        $wfi = new WFI()->wfi($this->adjacencyList);
        $e = [
            'A' => ['B' => 1, 'C' => 3, 'A' => 0],
            'B' => ['A' => 1, 'C' => 2, 'B' => 0],
            'C' => ['B' => 2, 'A' => 3, 'C' => 0],
            'D' => ['D' => 0],
            'E' => ['E' => 0]
        ];
        $this->assertSame($e, $wfi);
    }

    public function testMedianVertex()
    {
        $wfiMedian = new WFI()->medianVertex($this->adjacencyList);
        $this->assertSame('D', $wfiMedian);
    }

    public function testGraphCenter()
    {
        $nodesArray = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        $adjacencyList = new AdjacencyListImmutable();
        $nodes = new Nodes();
        $edges = new Edges();
        foreach ($nodesArray as $nodeName) {
            $nodes->add($nodeName);
        }
        $edges->addEdge('A', 'B', 1);
        $edges->addEdge('B', 'E', 1);
        $edges->addEdge('E', 'F', 1);
        $edges->addEdge('F', 'G', 1);
        $edges->addEdge('G', 'C', 1);
        $edges->addEdge('C', 'A', 1);
        $edges->addEdge('D', 'A', 1);
        $edges->addEdge('D', 'B', 1);
        $edges->addEdge('D', 'E', 1);
        $edges->addEdge('D', 'F', 1);
        $edges->addEdge('D', 'G', 1);
        $edges->addEdge('D', 'C', 1);
        $adjacencyList->setNodes($nodes)->setEdges($edges);

        $wfiGraphCenter = new WFI()->graphCenter($adjacencyList);
        $this->assertSame('D', $wfiGraphCenter);
    }
}
