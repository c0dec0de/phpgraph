<?php
declare(strict_types=1);

namespace Graph\Algorithms;

use Graph\GraphAbstract;

/**
 * Class WFI
 *
 * @package Graph\Algorithms
 */
class WFI
{

    /**
     * Floyd–Warshall algorithm
     * Find shortest paths between all pairs of vertices in directed weighted graph
     *
     * @param GraphAbstract $graph
     *
     * @return array
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
}
