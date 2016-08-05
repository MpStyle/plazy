<?php

namespace plazy\data;

/**
 * An optional value that may be none (no value) or some (a value). This type is a replacement for the use of null with
 * better type checks.
 *
 * @package mpstyle\plazy
 */
class Option
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var bool
     */
    private $isSome;

    /**
     * Option constructor.
     *
     * @param mixed $value
     * @param bool $isSome
     */
    private function __construct( $value, bool $isSome )
    {
        $this->value = $value;
        $this->isSome = $isSome;
    }

    /**
     * Constructs an optional value that has no value.
     *
     * @return Option
     */
    public static function none():Option
    {
        return new Option( null, false );
    }

    /**
     * Constructs an optional value that has a value of the given argument.
     *
     * @param mixed $value
     * @return Option
     */
    public static function some( $value ):Option
    {
        return new Option( $value, true );
    }

    /**
     * Turns an unsafe nullable value into a safe optional value.
     *
     * @param mixed $value
     * @return Option
     */
    public static function fromNull( $value ):Option
    {
        return new Option( $value, is_null( $value ) == false );
    }

    /**
     * Returns an optional non-empty string, or no value if the given string is empty.
     *
     * @param string $s
     * @return Option
     */
    public static function fromString( string $s ):Option
    {
        if( $s == '' || is_null( $s ) )
        {
            return Option::none();
        }

        return Option::some( $s );
    }

    /**
     * Returns an optional value that has a value of the given argument if the given boolean is true, otherwise,
     * returns no value
     *
     * @param bool $p
     * @param $value
     * @return Option
     */
    public static function iif( bool $p, $value ):Option
    {
        if( $p == true )
        {
            return Option::some( $value );
        }

        return Option::none();
    }

    /**
     * Returns true if this optional value has a value, false otherwise.
     *
     * @return boolean
     */
    public function isSome():bool
    {
        return $this->isSome;
    }

    /**
     * Returns false if this optional value has a value, true otherwise.
     *
     * @return bool
     */
    public function isNone():bool
    {
        return $this->isSome() === false;
    }

    /**
     * Returns the value from this optional value, or fails if there is no value.
     *
     * @return mixed
     */
    public function getSome()
    {
        return $this->value;
    }

    /**
     * @param Option $obj
     * @return bool
     */
    public function equals( Option $obj ):bool
    {
        return ( $this->value == $obj->value && $this->isSome == $obj->isSome );
    }

    /**
     * Returns this optional value if there is one, otherwise, returns the argument optional value.
     *
     * @param Option $value
     * @return Option
     */
    public function orElse( Option $value ):Option
    {
        if( $this->isSome() )
        {
            return $this;
        }

        return $value;
    }

    /**
     * Returns the value of this optional value or the given argument.
     *
     * @param mixed $value
     * @return mixed
     */
    public function orSome( $value )
    {
        if( $this->isSome() )
        {
            return $this->getSome();
        }

        return $value;
    }

    /**
     * Returns an array projection of this optional value.
     *
     * @return array
     */
    public function toArray():array
    {
        if( $this->isSome() )
        {
            return array( $this->getSome() );
        }

        return array();
    }

    /**
     * Returns the value from this optional value, or if there is no value, returns null.
     *
     * @return mixed|null
     */
    public function toNull()
    {
        if( $this->isSome() )
        {
            return $this->getSome();
        }

        return null;
    }
}