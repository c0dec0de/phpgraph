<?php
declare(strict_types = 1);

namespace Graph\Algorithms;

use Generator;
use Graph\GraphAbstract;
use SplQueue;

final class Bfs
{
    /**
     * Breadth-first search
     *
     * @param GraphAbstract $graph
     * @param string $v
     *
     * @return Generator<string>
     */
    public function bfs(GraphAbstract $graph, string $v): Generator
    {
        $q = new SplQueue();
        $discovered = [];
        $discovered[$v] = 1;
        yield $v;
        $q->enqueue($v);
        while ($q->isEmpty() === false) {
            /** @var string $v */
            $v = $q->dequeue();
            $directedEdges = $graph->adjacentEdgesIds($v);
            foreach ($directedEdges as $nodeId => $edgeWeight) {
                /** @var string $nodeName */
                $nodeName = $graph->nodesIdNameMap()[$nodeId];
                if (array_key_exists($nodeName, $discovered) === false) {
                    $discovered[$nodeName] = 1;
                    yield $nodeName;
                    $q->enqueue($nodeName);
                }
            }
        }
    }
}
