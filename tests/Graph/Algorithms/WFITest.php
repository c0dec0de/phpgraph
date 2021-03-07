<?php

namespace Graph\Algorithms;

use Graph\Representations\AdjacencyListImmutable;
use PHPUnit\Framework\TestCase;

class WFITest extends TestCase
{
    private $adjacencyList;
    public function setUp(): void
    {
        $nodesArray = ['A', 'B', 'C', 'D', 'E'];
        $adjacencyList = new AdjacencyListImmutable();
        $nodes = new \Graph\Representations\Nodes();
        $edges = new \Graph\Representations\Edges();
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
        $wfi = (new WFI())->wfi($this->adjacencyList);
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
        $wfiMedian = (new WFI())->medianVertex($this->adjacencyList);
        $this->assertSame('D', $wfiMedian);
    }
}
