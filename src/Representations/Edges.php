<?php
declare(strict_types=1);

namespace Graph\Representations;

use Graph\Structures\FixedArray;

class Edges extends FixedArray
{
    /**
     * @param string $node1
     * @param string $node2
     * @param int $weight
     * @param bool $ordered
     *
     * @return int
     */
    public function addEdge(string $node1, string $node2, int $weight, bool $ordered = true): int
    {
        return parent::add(
            new Edge($node1, $node2, $weight, $ordered)
        );
    }
}
