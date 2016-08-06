<?php
namespace plazy\func;

interface Predicate
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function matches( $value):bool;
}