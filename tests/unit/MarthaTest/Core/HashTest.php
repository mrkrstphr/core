<?php

namespace MarthaTest\Core;

use Martha\Core\Hash;

/**
 * Class HashTest
 * @package MarthaTest\Core
 */
class HashTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the data is initialized properly when no data is passed, and that the toArray() and toJson()
     * methods handle it properly.
     */
    public function testEmptyInstantiation()
    {
        $hash = new Hash();

        $this->assertInternalType('array', $hash->toArray());
        $this->assertEmpty($hash->toArray());

        $this->assertInternalType('string', $hash->toJson());
        $this->assertEquals('[]', $hash->toJson());
    }

    /**
     * Test that data is stored and retrieved properly when passing to the constructor.
     */
    public function testProvidedInstantiation()
    {
        $expectedArray = [
            'foo' => 'bar',
            'biz' => 'baz'
        ];
        $expectedJson = json_encode($expectedArray, true);

        $hash = new Hash($expectedArray);

        $this->assertTrue($hash->has('foo'));
        $this->assertTrue($hash->has('biz'));

        $this->assertEquals($expectedArray['foo'], $hash->get('foo'));
        $this->assertEquals($expectedArray['biz'], $hash->get('biz'));

        $this->assertEquals($expectedArray, $hash->toArray());
        $this->assertEquals($expectedJson, $hash->toJson());
    }

    /**
     * Test that calling get() on a non-existent key returns null.
     */
    public function testBadGetReturnsNull()
    {
        $hash = new Hash();

        $this->assertNull($hash->get('foo'));
    }

    /**
     * Test that the has() method works as expected.
     */
    public function testHas()
    {
        $hash = new Hash();
        $this->assertFalse($hash->has('foo'));

        $hash->set('foo', 'bar');
        $this->assertTrue($hash->has('foo'));
    }

    /**
     * Test that set() and get() methods work as expected.
     */
    public function testSetAndGet()
    {
        $hash = new Hash(['biz' => 'baz']);
        $hash->set('foo', 'bar');

        $this->assertTrue($hash->has('foo'));
        $this->assertEquals('bar', $hash->get('foo'));
    }

    /**
     * Test the toArray() method.
     */
    public function testToArray()
    {
        $hash = new Hash(['biz' => 'baz']);
        $hash->set('foo', 'bar');

        $expected = ['biz' => 'baz', 'foo' => 'bar'];

        $this->assertEquals($expected, $hash->toArray());
    }

    /**
     * Test the toJson() method.
     */
    public function testToJson()
    {
        $hash = new Hash(['biz' => 'baz']);
        $hash->set('foo', 'bar');

        $expected = '{"biz":"baz","foo":"bar"}';

        $this->assertEquals($expected, $hash->toJson());
    }
}
