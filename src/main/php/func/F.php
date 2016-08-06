<?php

namespace plazy\func;

/**
 * A transformation or function from A to B.
 */
interface F
{
    /**
     * Transform $a to B.
     *
     * @param mixed $a
     * @return mixed
     */
    public function f( $a );
}