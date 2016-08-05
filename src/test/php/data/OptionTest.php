<?php

namespace plazy\data;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $helloWorld = 'Hello world!';

    public function test_none()
    {
        $this->assertNull( Option::none()->getSome() );
    }

    public function test_some()
    {
        $this->assertEquals( $this->helloWorld, Option::some( $this->helloWorld )->getSome() );
    }

    public function test_fromNull()
    {
        $this->assertTrue( Option::fromNull( null )->isNone() );
        $this->assertTrue( Option::fromNull( $this->helloWorld )->isSome() );
    }

    public function test_fromString()
    {
        $helloWorld = $this->helloWorld;

        $this->assertEquals( $helloWorld, Option::fromString( $helloWorld )->getSome() );
    }

    public function test_iif()
    {
        $this->assertTrue( Option::iif( false, $this->helloWorld )->isNone() );
        $this->assertTrue( Option::iif( true, $this->helloWorld )->isSome() );
    }

    public function test_isSome()
    {
        $this->assertTrue( Option::some( $this->helloWorld )->isSome() );
        $this->assertFalse( Option::none()->isSome() );
    }

    public function test_isNone()
    {
        $this->assertFalse( Option::some( $this->helloWorld )->isNone() );
        $this->assertTrue( Option::none()->isNone() );
    }

    public function test_equals()
    {
        $option = Option::some( $this->helloWorld );
        $this->assertTrue( $option->equals( Option::some( $this->helloWorld ) ) );
    }

    public function test_orElse()
    {
        $this->assertEquals( $this->helloWorld, Option::none()->orElse( Option::some( $this->helloWorld ) )->getSome() );
    }

    public function test_orSome()
    {
        $this->assertEquals( $this->helloWorld, Option::none()->orSome( $this->helloWorld ) );
    }

    public function test_toArray()
    {
        $this->assertTrue( count( Option::none()->toArray() ) == 0 );
        $this->assertTrue( count( Option::some( $this->helloWorld )->toArray() ) == 1 );
    }

    public function test_toNull()
    {
        $this->assertNull( Option::none()->toNull() );
        $this->assertEquals( $this->helloWorld, Option::some( $this->helloWorld )->toNull() );
    }
}
