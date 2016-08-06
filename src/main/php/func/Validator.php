<?php
namespace plazy\func;

interface Validator
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value):bool;
}