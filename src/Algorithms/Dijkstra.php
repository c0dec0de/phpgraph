<?php
declare(strict_types = 1);

namespace Graph\Algorithms;

use Generator;
use Graph\GraphAbstract;
use Graph\PriorityQueue;
use SplPriorityQueue;

final class Dijkstra
{
    private int $maxDistance;

    /**
     * Dijkstra constructor.
     */
    public function __construct()
    {
        $this->maxDistance = PHP_INT_MAX - 10000000000;
    }

    /**
     * @param GraphAbstract $graph
     * @param string $source
     *
     * @return Generator<array>
     *
     * @psalm-suppress MixedArrayOffset
     */
    public function dijkstraArrayImpl(GraphAbstract $graph, string $source): Generator
    {
        $distance = [];
        $idNameMap = $graph->nodesIdNameMap();

        $q = [];
        foreach ($graph->nodesIdNameMap() as $nodeId => $nodeName) {
            $distance[$nodeName] = $this->maxDistance;
            $q[$nodeName] = $this->maxDistance;
        }
        $distance[$source] = 0;
        $q[$source] = 0;

        while ($q) {
            $u = $this->extractMin($q);
            if ($u === null) {
                break;
            }
            /** @var string $uVertexName */
            $uVertexName = key($u);
            foreach ($graph->adjacentEdgesIds($uVertexName) as $zId => $edgeWeight) {
                $zVertexName = (string) $idNameMap[$zId];
                if (isset($q[$zVertexName]) === false) {
                    continue;
                }

                $alt = $distance[$uVertexName] + $edgeWeight;
                if ($alt < $distance[$zVertexName]) {
                    $distance[$zVertexName] = $alt;
                    $q[$zVertexName] = $alt;
                    yield [$zVertexName => $alt];
                }
            }
        }
    }

    /**
     * Dijkstra implementation using priority queue
     *
     * @param GraphAbstract $graph
     * @param string $source
     *
     * @return Generator<array>
     *
     * @psalm-suppress MixedArrayOffset
     */
    public function dijkstraPriorityQueue(GraphAbstract $graph, string $source): Generator
    {
        $priorityQueue = new PriorityQueue();
        $priorityQueue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

        $distance = [];
        $idNameMap = $graph->nodesIdNameMap();

        foreach ($graph->nodesIdNameMap() as $nodeId => $nodeName) {
            if ($nodeName === $source) {
                continue;
            }
            $distance[$nodeName] = $this->maxDistance;
            $priorityQueue->insert($nodeName, $this->maxDistance);
        }

        $distance[$source] = 0;
        $priorityQueue->insert($source, 0);

        while ($priorityQueue->valid()) {
            /** @var array{data: string, priority: int} $u */
            $u = $priorityQueue->extract();
            $uVertexName = $u['data'];
            foreach ($graph->adjacentEdgesIds($uVertexName) as $zId => $edgeWeight) {
                $zVertexName = (string) $idNameMap[$zId];
                if ($priorityQueue->isInQueue($zVertexName) === false) {
                    continue;
                }
                /** @var int $alt */
                $alt = $distance[$uVertexName] + $edgeWeight;
                if ($alt < $distance[$zVertexName]) {
                    $distance[$zVertexName] = $alt;
                    $priorityQueue->insert($zVertexName, $alt);
                    yield [$zVertexName => $alt];
                }
            }
        }
    }

    /**
     * @param array<array-key,int> $array $array
     *
     * @return array<array-key,int>|null
     */
    private function extractMin(array &$array): ?array
    {
        asort($array);

        if (null === $minElementKey = array_key_first($array)) {
            return null;
        }
        $min = [$minElementKey => $array[$minElementKey]];
        unset($array[$minElementKey]);

        return $min;
    }
}
