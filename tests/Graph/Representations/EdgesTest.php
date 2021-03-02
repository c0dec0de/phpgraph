<?php

namespace Graph\Representations;

use PHPUnit\Framework\TestCase;

class EdgesTest extends TestCase
{

    public function testAddEdge()
    {
        $edges = new Edges();
        $edge1 = new Edge('A','B', 100, true);
        $edge2 = new Edge('C','A', 100, true);
        $edge3 = new Edge('B','E', 100, true);
        $edges->add($edge1);
        $edges->add($edge2);
        $edges->add($edge3);
        $this->assertCount(3, $edges->toArray());
    }
}
