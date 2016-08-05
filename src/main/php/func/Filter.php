<?php
namespace plazy\func;

interface Filter
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function filter($value):bool;
}