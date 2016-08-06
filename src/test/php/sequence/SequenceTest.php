<?php

namespace plazy\sequence;

use plazy\func\Predicate;

class SequenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $testArray = array(1, 2, 3);

    public function test_sequence()
    {
        $this->assertEquals( $this->testArray, Sequence::sequence( 1, 2, 3 )->toPHPArray() );
    }

    public function test_take()
    {
        $this->assertEquals( $this->testArray, Sequence::sequence( 1, 2, 3, 4 )->take( 3 )->toPHPArray() );
    }

    public function test_drop()
    {
        $this->assertEquals( $this->testArray, Sequence::sequence( 4, 1, 2, 3 )->drop( 1 )->toPHPArray() );
    }

    public function test_tail()
    {
        $this->assertEquals( $this->testArray, Sequence::sequence( 4, 1, 2, 3 )->tail()->toPHPArray() );
    }

    public function test_head()
    {
        $this->assertEquals( 1, Sequence::sequence( 1, 2, 3 )->head() );
    }

    public function test_headOption()
    {
        $this->assertEquals( 1, Sequence::sequence( 1, 2, 3 )->headOption()->getSome() );
    }

    public function test_contains()
    {
        $this->assertTrue( Sequence::sequence( 1, 2, 3 )->contains( 1 ) );
    }

    public function test_toString()
    {
        $this->assertEquals( '1,2,3', Sequence::sequence( 1, 2, 3 )->toString( ',' ) );
    }

    public function test_isEmpty()
    {
        $this->assertTrue( Sequence::sequence()->isEmpty() );
    }

    public function test_size()
    {
        $this->assertEquals( 0, Sequence::sequence()->size() );
    }

    public function test_indexOf()
    {
        $this->assertEquals( 0, Sequence::sequence( 1, 2, 3 )->indexOf( 1 ) );
    }

    public function test_index()
    {
        $this->assertEquals( 1, Sequence::sequence( 1, 2, 3 )->index( 0 ) );
    }

    public function test_filter()
    {
        $array = Sequence::sequenceFromPHPArray( $this->testArray )->filter( new Mod2Filter() )->toPHPArray();

        $this->assertEquals( array(1, 3), $array );
    }

    public function test_map()
    {
        $array = Sequence::sequenceFromPHPArray( $this->testArray )->map( new ToStringMapper() )->toPHPArray();

        $this->assertEquals( array('1', '2', '3'), $array );
    }

    public function test_first()
    {
        $this->assertEquals( 1, Sequence::sequence( 1, 2, 3 )->first() );
    }

    public function test_last()
    {
        $this->assertEquals( 3, Sequence::sequence( 1, 2, 3 )->last() );
    }

    public function test_lastOption()
    {
        $this->assertEquals( 3, Sequence::sequence( 1, 2, 3 )->lastOption()->getSome() );
    }

    public function test_second()
    {
        $this->assertEquals( 2, Sequence::sequence( 1, 2, 3 )->second() );
    }

    public function test_third()
    {
        $this->assertEquals( 3, Sequence::sequence( 1, 2, 3 )->third() );
    }

    public function test_appendTo()
    {
        $this->assertEquals( $this->testArray, Sequence::sequence( 1, 2 )->appendTo( 3 )->toPHPArray() );
    }

    public function test_delete()
    {
        $this->assertEquals( $this->testArray, Sequence::sequence( 1, 2, 3, 4 )->delete( 4 )->toPHPArray() );
    }

    public function test_forAll()
    {
        $copy = new class(Sequence::sequence()) implements Predicate
        {
            /**
             * @var Sequence
             */
            private $a;

            public function __construct( Sequence $a )
            {
                $this->a = $a;
            }

            /**
             * @param mixed $value
             * @return bool
             */
            public function matches( $value ):bool
            {
                $this->a = $this->a->appendTo( $value * $value );
                return true;
            }

            /**
             * @return Sequence
             */
            public function getA(): Sequence
            {
                return $this->a;
            }
        };

        Sequence::sequenceFromPHPArray( $this->testArray )->forAll( $copy );

        $this->assertEquals( array(1, 4, 9), $copy->getA()->toPHPArray() );
    }
}
