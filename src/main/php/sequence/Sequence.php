<?php

namespace plazy\sequence;

use plazy\data\Option;
use plazy\func\Predicate;
use plazy\func\F;

/**
 * The sequence class allows you to build up a computation out of smaller operations. It's similar to Java 8
 * Streams.<br> Usages:
 * <code>
 * Sequence::sequence(1,2,3);
 * </code>
 *
 * @package plazy\sequence
 */
class Sequence implements \Iterator, \ArrayAccess
{
    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var array
     */
    private $values = array();

    /**
     * Sequence constructor.
     *
     * @param array $values
     */
    private function __construct( array $values )
    {
        $this->values = $values;
    }

    /**
     * @param array ...$values
     * @return Sequence
     */
    public static function sequence( ...$values ):Sequence
    {
        return new Sequence( $values );
    }

    /**
     * @param array $values
     * @return Sequence
     */
    public static function sequenceFromPHPArray( array $values ):Sequence
    {
        return new Sequence( $values );
    }

    /**
     * @param int $number
     * @return Sequence
     */
    public function take( int $number ):Sequence
    {
        return Sequence::sequenceFromPHPArray( array_slice( $this->values, 0, $number ) );
    }

    /**
     * @param int $number
     * @return Sequence
     */
    public function drop( int $number ):Sequence
    {
        return Sequence::sequenceFromPHPArray( array_slice( $this->values, $number ) );
    }

    /**
     * @return Sequence
     */
    public function tail():Sequence
    {
        return Sequence::sequenceFromPHPArray( $this->values )->drop( 1 );
    }

    /**
     * @return mixed
     */
    public function head()
    {
        return $this->values[0];
    }

    /**
     * @return Option
     */
    public function headOption():Option
    {
        return Option::fromNull( $this->values[0] );
    }

    /**
     * @param $value
     * @return bool
     */
    public function contains( $value ):bool
    {
        return in_array( $value, $this->values );
    }

    /**
     * @param string $separator
     * @return string
     */
    public function toString( string $separator ):string
    {
        return implode( $separator, $this->values );
    }

    /**
     * @return bool
     */
    public function isEmpty():bool
    {
        return (count( $this->values ) <= 0);
    }

    /**
     * @return int
     */
    public function size():int
    {
        return count( $this->values );
    }

    /**
     * @param $value
     * @return int
     */
    public function indexOf( $value ):int
    {
        $pos = array_search( $value, $this->values );

        if( $pos === false )
        {
            return -1;
        }

        return $pos;
    }

    /**
     * @param int $i
     * @return mixed
     */
    public function index( int $i )
    {
        return $this->values[$i];
    }

    /**
     * Iterates over each value in the {@link Sequence}
     * passing them to the <b>function</b> function.
     * If the <b>function</b> returns true, the
     * current value from {@link Sequence} is returned into
     * the result {@link Sequence}.
     *
     * @param Predicate $function
     * @return Sequence
     */
    public function filter( Predicate $function ):Sequence
    {
        return Sequence::sequenceFromPHPArray(
            array_values(
                array_filter(
                    $this->values,
                    array($function, 'matches')
                )
            )
        );
    }

    /**
     * Applies the <b>function</b> to the elements of the {@link Sequence}.
     *
     * @param F $function
     * @return Sequence
     */
    public function map( F $function ):Sequence
    {
        return Sequence::sequenceFromPHPArray( array_map( array($function, 'f'), $this->values ) );
    }

    /**
     * Apply the {@link Predicate} to every member of the {@link Sequence}.
     *
     * @param Predicate $p
     */
    public function forAll( Predicate $p ):void
    {
        array_walk( $this->values, array($p, 'matches') );
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->head();
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return $this->values[$this->size() - 1];
    }

    /**
     * @return Option
     */
    public function lastOption():Option
    {
        return Option::fromNull( $this->values[$this->size() - 1] );
    }

    /**
     * @return mixed
     */
    public function second()
    {
        return $this->values[1];
    }

    /**
     * @return mixed
     */
    public function third()
    {
        return $this->values[2];
    }

    /**
     * @param $appendable
     * @return Sequence
     */
    public function appendTo( $appendable ):Sequence
    {
        $values = $this->values;
        $values[] = $appendable;

        return Sequence::sequenceFromPHPArray( $values );
    }

    /**
     * @param $value
     * @return Sequence
     */
    public function delete( $value ):Sequence
    {
        $values = $this->values;
        $pos = array_search( $value, $values );
        unset($values[$pos]);

        return Sequence::sequenceFromPHPArray( $values );
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->values[$this->offset];
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->offset++;
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->offset;
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->offsetExists( $this->offset );
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->offset = 0;
    }

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     * @return boolean true on success or false on failure.
     *                      </p>
     *                      <p>
     *                      The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists( $offset )
    {
        return ($offset >= 0 && $offset < count( $this->values ));
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet( $offset )
    {
        return $this->values[$offset];
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet( $offset, $value )
    {
        $this->values[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset( $offset )
    {
        unset($this->values[$offset]);
    }

    /**
     * @return array
     */
    public function toPHPArray()
    {
        return $this->values;
    }
}