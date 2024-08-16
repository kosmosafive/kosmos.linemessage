<?php

namespace Kosmos\LineMessage\Line;

use Kosmos\LineMessage\Collection;

class LineCollection extends Collection
{
    public function add(Line $line): LineCollection
    {
        $this->values[] = $line;
        return $this;
    }
}
