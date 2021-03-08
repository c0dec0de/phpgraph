<?php
declare(strict_types=1);

namespace Graph\Algorithms;

use Graph\GraphAbstract;

/**
 * Class WFI
 *
 * @package Graph\Algorithms
 */
final class WFI
{

    /**
     * Floyd–Warshall algorithm
     * Find shortest paths between all pairs of vertices in directed weighted graph
     *
     * @param GraphAbstract $graph
     *
     * @return array<array-key,array>
     */
    public function wfi(GraphAbstract $graph): array
    {
        $dist = [];
        $nodes = $graph->nodesNameIdMap();
        /** @var array{0: string, 1: string, 2: int} $edge */
        foreach ($graph->edges() as $key => $edge) {
            $dist[$edge['0']][$edge['1']] = $edge['2'];
        }

        foreach ($nodes as $vertexLabel => $id) {
            $dist[$vertexLabel][$vertexLabel] = 0;
        }
        foreach ($nodes as $k => $kId) {
            foreach ($nodes as $i => $iId) {
                foreach ($nodes as $j => $jId) {
                    /** @var int $ij */
                    $ij = $dist[$i][$j] ?? PHP_INT_MAX;
                    /** @var int $ikKj */
                    $ikKj = (($dist[$i][$k] ?? PHP_INT_MAX) + ($dist[$k][$j] ?? PHP_INT_MAX));
                    if ($ij > $ikKj) {
                        $dist[$i][$j] = $ikKj;
                    }
                }
            }
        }

        return $dist;
    }

    /**
     * Find median vertex using Floyd Warshall Algorithm
     * Median vertex for which the sum of lengths of shortest paths to all other vertices is the smallest.
     * More: http://www.graph-magics.com/articles/median.php
     *
     * @param GraphAbstract $graphAbstract
     *
     * @return int|string|null
     */
    public function medianVertex(GraphAbstract $graphAbstract): int|string|null
    {
        $A = $this->wfi($graphAbstract);

        foreach ($A as $vertexName => &$path) {
            $path = array_sum($path);
        }

        $median = null;

        foreach ($graphAbstract->nodesNameIdMap() as $kName => $kId) {
            /** @var array<array-key,int> $A */
            $medianSum = $A[$median] ?? PHP_INT_MAX;
            if ($A[$kName] < $medianSum) {
                $median = $kName;
            }
        }

        return $median;
    }
}
