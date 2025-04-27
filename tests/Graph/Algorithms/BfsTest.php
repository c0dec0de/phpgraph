<?php

namespace GraphTests\Graph\Algorithms;

use Graph\Algorithms\Bfs;
use Graph\Representations\AdjacencyListImmutable;
use PHPUnit\Framework\TestCase;

class BfsTest extends TestCase
{

    public function testBfs()
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
        $adjacencyList->setNodes($nodes)->setEdges($edges);
        $bfs = new Bfs()->bfs($adjacencyList, 'A');
        $steps = [];
        while ($bfs->valid()) {
            $steps[] = $bfs->current();
            $bfs->next();
        }
        $this->assertSame(['A', 'B', 'C'], $steps);
    }
}
