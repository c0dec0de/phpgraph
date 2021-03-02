<?php
declare(strict_types=1);

namespace Graph\Structures;

class FixedArray extends \SplFixedArray
{
    /**
     * Add value
     *
     * @param mixed $value
     *
     * @return int index of added value
     * @psalm-suppress MixedAssignment
     */
    public function add(mixed $value): int
    {
        $size = $this->getSize();
        $this->setSize($size + 1);
        $this[$size] = $value;

        return $size;
    }
}
