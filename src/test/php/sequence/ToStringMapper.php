<?php

namespace plazy\sequence;

use plazy\func\F;

class ToStringMapper implements F
{

    /**
     * @param mixed $value
     * @return mixed
     */
    public function f( $value )
    {
        return '' . $value;
    }
}