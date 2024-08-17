<?php

declare(strict_types=1);

namespace Kosmos\LineMessage\Line;

use Kosmos\LineMessage\Structure\Collection as Base;

class Collection extends Base
{
    public function __construct(LineInterface ...$lines)
    {
        parent::__construct();

        $this->values = $lines;
    }

    public function add(LineInterface $line): Collection
    {
        $this->values[] = $line;
        return $this;
    }
}
