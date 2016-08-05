<?php

namespace plazy\sequence;

use plazy\func\Mapper;

class ToStringMapper implements Mapper
{

    /**
     * @param mixed $value
     * @return mixed
     */
    public function map( $value )
    {
        return '' . $value;
    }
}