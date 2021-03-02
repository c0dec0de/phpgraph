<?php
declare(strict_types=1);

namespace Graph;

use SplFixedArray;

abstract class GraphAbstract
{
    protected ?bool $isDigraph;

    /**
     * @var array<array-key, int>
     */
    protected array $nodesNameIdMap;
    /**
     * @var array<array-key, string>|SplFixedArray
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
     * @return array<array-key, string>|SplFixedArray
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
     * @param array|SplFixedArray $nodeNames
     *
     * @return $this
     */
    public abstract function setNodes(array|SplFixedArray $nodeNames): self;

    /**
     * @param array|SplFixedArray $edges
     *
     * @return $this
     */
    public abstract function setEdges(array|SplFixedArray $edges): self;

    /**
     * @return array
     */
    public abstract function edges(): array;

    /**
     * @param string $vertex
     *
     * @return SplFixedArray|array<int,int>
     */
    public abstract function adjacentEdgesIds(string $vertex): SplFixedArray|array;
}