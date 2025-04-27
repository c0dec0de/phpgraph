<?php

namespace GraphTests\Graph\Representations;

use Graph\Representations\AdjacencyListImmutable;
use Graph\Representations\Edges;
use Graph\Representations\Nodes;
use PHPUnit\Framework\TestCase;

class AdjacencyListImmutableTest extends TestCase
{

    public function testSetNodes()
    {
        $nodesArray = ['A', 'B', 'C', 'D', 'E'];
        $adjacencyList = new AdjacencyListImmutable();
        $nodes = new Nodes();
        foreach ($nodesArray as $nodeName) {
            $nodes->add($nodeName);
        }
        $adjacencyList->setNodes($nodes);
        $nodesNames = $adjacencyList->nodesNameIdMap();
        $this->assertCount(sizeof($nodesArray), $nodesNames);
        $this->assertSame(array_keys($nodesNames), $nodesArray);
    }

    public function testList()
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
        $adjacencyList->setNodes($nodes)->setEdges($edges);
        $list = $adjacencyList->list();
        $this->assertCount(5, $list);
    }

    public function testAdjacentEdgesIds()
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
        $adjacencyList->setNodes($nodes)->setEdges($edges);
        $adjacencyEdgesA = $adjacencyList->adjacentEdgesIds('A');
        $adjacencyEdgesB = $adjacencyList->adjacentEdgesIds('B');
        $adjacencyEdgesC = $adjacencyList->adjacentEdgesIds('C');
        $this->assertSame(['1' => 1, '2' => 3], $adjacencyEdgesA);
        $this->assertSame(['0' => 1, '2' => 2], $adjacencyEdgesB);
        $this->assertSame(['1' => 2, '0' => 3], $adjacencyEdgesC);
    }

    public function testEdges()
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
        $adjacencyList->setNodes($nodes)->setEdges($edges);
        $edgesE = [['A', 'B', 1], ['A', 'C', 3], ['B', 'A', 1], ['B', 'C', 2], ['C', 'B', 2], ['C', 'A', 3]];
        $this->assertSame($edgesE, $adjacencyList->edges());
    }
}
