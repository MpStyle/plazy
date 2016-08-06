<?php

namespace plazy\sequence;

use plazy\func\Predicate;

class Mod2Filter implements Predicate
{
    public function matches( $value):bool
    {
        return ( $value % 2 == 1 );
    }
}