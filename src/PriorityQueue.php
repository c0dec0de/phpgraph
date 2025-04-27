<?php
declare(strict_types = 1);

namespace Graph;

use SplPriorityQueue;

/**
 * Class PriorityQueue
 *
 * @extends SplPriorityQueue<mixed,mixed>
 *
 * @package Graph
 */
final class PriorityQueue extends SplPriorityQueue
{
    /**
     * @param mixed $priority1
     * @param mixed $priority2
     *
     * @return int
     */
    public function compare(mixed $priority1, mixed $priority2): int
    {
        if ($priority1 === $priority2) {
            return 0;
        }

        return ($priority1 < $priority2) ? 1 : -1;
    }

    /**
     * Checks if element is in queue
     *
     * @param mixed $element
     *
     * @return bool
     */
    public function isInQueue(mixed $element): bool
    {
        $queue = clone $this;
        $queue->setExtractFlags(SplPriorityQueue::EXTR_DATA);

        return in_array($element, iterator_to_array($queue), true);
    }
}
