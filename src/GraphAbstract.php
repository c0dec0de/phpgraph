<?php
declare(strict_types = 1);

namespace Graph;

use SplFixedArray;

/**
 * Class GraphAbstract
 *
 * @package Graph
 */
abstract class GraphAbstract
{
    protected ?bool $isDigraph;

    /**
     * @var array<array-key, int>
     */
    protected array $nodesNameIdMap;
    /**
     * @var array<array-key, string>|SplFixedArray<mixed>
     */
    protected array|SplFixedArray $nodesIdNameMap;

    /**
     * GraphAbstract constructor.
     */
    public function __construct()
    {
        $this->isDigraph = null;
        $this->nodesNameIdMap = [];
        $this->nodesIdNameMap = new SplFixedArray();
    }

    /**
     * @return $this
     */
    public function setDirected(): self
    {
        $this->isDigraph = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function setUndirected(): self
    {
        $this->isDigraph = false;

        return $this;
    }

    /**
     * @return array<array-key, string>|SplFixedArray<mixed>
     */
    public function nodesIdNameMap(): array|SplFixedArray
    {
        return $this->nodesIdNameMap;
    }

    /**
     * @return array<array-key, int>
     */
    public function nodesNameIdMap(): array
    {
        return $this->nodesNameIdMap;
    }

    /**
     * @param array<array-key,mixed>|SplFixedArray<mixed> $nodeNames
     *
     * @return $this
     */
    abstract public function setNodes(array|SplFixedArray $nodeNames): self;

    /**
     * @param array<array-key,mixed>|SplFixedArray<mixed> $edges
     *
     * @return $this
     */
    abstract public function setEdges(array|SplFixedArray $edges): self;

    /**
     * @return array<array-key,array>
     */
    abstract public function edges(): array;

    /**
     * @param string $vertex
     *
     * @return array<int,int>|SplFixedArray<mixed>
     */
    abstract public function adjacentEdgesIds(string $vertex): array|SplFixedArray;
}
