<?php

namespace plazy\sequence;

use plazy\func\Filter;

class Mod2Filter implements Filter
{
    public function filter($value):bool
    {
        return ( $value % 2 == 1 );
    }
}