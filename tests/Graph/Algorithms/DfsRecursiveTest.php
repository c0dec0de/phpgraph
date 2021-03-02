<?php

namespace Graph\Algorithms;

use Graph\Representations\AdjacencyListImmutable;
use PHPUnit\Framework\TestCase;

class DfsRecursiveTest extends TestCase
{

    public function testDfsRecursive()
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
        $dfs = (new DfsRecursive())->dfsRecursive($adjacencyList, 'A');
        $steps = [];
        while ($dfs->valid()) {
            $steps[] = $dfs->current();
            $dfs->next();
        }
        $this->assertSame(['A', 'B', 'C'], $steps);
    }
}
