<?php

namespace GraphTests\Graph\Representations;

use Graph\Representations\Edge;
use PHPUnit\Framework\TestCase;

class EdgeTest extends TestCase
{
    public function testSuccess()
    {
        $edge = new Edge($node1 = 'A', $node2 = 'B', $weight = 100, $ordered = true);
        $this->assertSame($node1, $edge->node1);
        $this->assertSame($node2, $edge->node2);
        $this->assertSame($weight, $edge->weight);
        $this->assertSame($ordered, $edge->ordered);
    }
}
