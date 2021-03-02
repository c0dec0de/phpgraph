<?php
declare(strict_types=1);

namespace Graph\Representations;

use Graph\GraphAbstract;
use InvalidArgumentException;
use LogicException;
use SplFixedArray;

/**
 * Class AdjacencyListImmutable
 */
class AdjacencyListImmutable extends GraphAbstract
{
    private SplFixedArray $list;
    private bool $edgesSetFlag;

    /**
     * AdjacencyListImmutable constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->list = new SplFixedArray(0);
        $this->edgesSetFlag = false;
    }

    /**
     * Return adjacency list
     *
     * @return SplFixedArray
     */
    public function list(): SplFixedArray
    {
        return $this->list;
    }

    /**
     * Return edges
     *
     * @return array
     */
    public function edges(): array
    {
        $edgesList = [];
        /** @var SplFixedArray $edges */
        foreach ($this->list as $node => $edges) {
            /** @var array<int, int> $edge */
            foreach ($edges as $edge) {
                $edgesList[] = [
                    $this->nodesIdNameMap[$node],
                    $this->nodesIdNameMap[$edge['0']],
                    $edge['1']
                ];
            }
        }

        return $edgesList;
    }

    /**
     * @param array|SplFixedArray $nodeNames
     *
     * @throws LogicException
     *
     * @return GraphAbstract
     */
    public function setNodes(array|SplFixedArray $nodeNames): GraphAbstract
    {
        if (sizeof($this->list) !== 0) {
            throw new LogicException('Nodes already been set');
        }
        $this->list->setSize(sizeof($nodeNames));
        // Before SplFixedArray solution
        // $this->nodesIdNameMap = array_unique($nodeNames);
        /** @var array<array-key, string> $nodeNames */
        $this->nodesIdNameMap = $nodeNames;
        /** @var int $value */
        foreach ($nodeNames as $key => $value) {
            $this->nodesNameIdMap[$value] = (int)$key;
        }
        //        $this->nodesNameIdMap = array_flip($this->nodesIdNameMap);

        /** @var mixed $value */
        foreach ($this->list() as $key => $value) {
            $this->list[$key] = new SplFixedArray(0);
        }

        return $this;
    }

    /**
     * @param array|SplFixedArray $edges
     *
     * @throws LogicException
     *
     * @return GraphAbstract
     */
    public function setEdges(array|SplFixedArray $edges): GraphAbstract
    {
        if ($this->edgesSetFlag) {
            throw new LogicException('Edges already been set');
        }

        /** @var Edge $edge */
        foreach ($edges as $edge) {
            $from = $edge->node1;
            $to = $edge->node2;

            $ordered = $edge->ordered;
            $weight = $edge->weight;

            /** @var int|false $end1MapKey */
            $end1MapKey = $this->nodesNameIdMap[$from] ?? false;
            /** @var int|false $end2MapKey */
            $end2MapKey = $this->nodesNameIdMap[$to] ?? false;

            $isPairOrdered = ($this->isDigraph === null ? $ordered === true : !$this->isDigraph);
            if ($end1MapKey === false || $end2MapKey === false) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Node "%s" not found',
                        ($end1MapKey === false ? $from : $to)
                    )
                );
            }

            $this->addEdge($end1MapKey, $end2MapKey, $weight);
            if ($isPairOrdered) {
                $this->addEdge($end2MapKey, $end1MapKey, $weight);
            }
        }
        $this->edgesSetFlag = true;

        return $this;
    }

    /**
     * @param $fromKey
     * @param $toKey
     * @param $weight
     *
     * @return void
     *
     * @psalm-suppress MixedArrayAssignment
     */
    private function addEdge(int $fromKey, int $toKey, int $weight): void
    {
        /** @var SplFixedArray $nodeRow */
        $nodeRow = $this->list[$fromKey];
        $currentSize = $nodeRow->getSize();
        $newSize = $currentSize + 1;
        $nodeRow->setSize($newSize);
        $this->list[$fromKey][$currentSize] = new SplFixedArray(2);
        $this->list[$fromKey][$currentSize][0] = $toKey;
        $this->list[$fromKey][$currentSize][1] = $weight;
    }

    /**
     * @param string $vertex
     *
     * @return array<int, int>
     */
    public function adjacentEdgesIds(string $vertex): array
    {

        /** @var int $vertexId */
        $vertexId = $this->nodesNameIdMap[$vertex];
        $adjacentEdges = [];
        /** @var array<array-key, int> $vertexInfo */
        foreach ($this->list[$vertexId] as $vertexInfo) {
            $adjacentEdges[$vertexInfo['0']] = $vertexInfo['1'];
        }

        return $adjacentEdges;
    }
}
