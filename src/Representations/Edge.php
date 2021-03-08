<?php
declare(strict_types=1);

namespace Graph\Representations;

final class Edge
{
    public string $node1;
    public string $node2;
    public int $weight;
    public bool $ordered;

    /**
     * Edge constructor.
     *
     * @param string $node1
     * @param string $node2
     * @param int $weight
     * @param bool $ordered
     */
    public function __construct(string $node1, string $node2, int $weight = 1, bool $ordered = true)
    {
        $this->node1 = $node1;
        $this->node2 = $node2;
        $this->weight = $weight;
        $this->ordered = $ordered;
    }
}
