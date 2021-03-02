<?php
declare(strict_types=1);

namespace Graph\Algorithms;

use Generator;
use Graph\GraphAbstract;

/**
 * Class DfsRecursive
 */
class DfsRecursive
{
    /**
     * @var array<array-key,string>
     */
    private array $discovered;

    /**
     * DfsRecursive constructor.
     */
    public function __construct()
    {
        $this->discovered = [];
    }

    /**
     * @param GraphAbstract $graph
     * @param string $v
     *
     * @return Generator
     */
    public function dfsRecursive(GraphAbstract $graph, string $v): Generator
    {
        $this->discovered[$v] = 1;
        yield $v;
        $directedEdges = $graph->adjacentEdgesIds($v);
        foreach ($directedEdges as $nodeId => $edgeWeight) {
            $nodeName = (string)$graph->nodesIdNameMap()[$nodeId];
            if (array_key_exists($nodeName, $this->discovered) === false) {
                yield from self::dfsRecursive($graph, $nodeName);
            }
        }
    }
}
