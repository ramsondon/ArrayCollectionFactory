<?php
/**
 * UntypedArrayTest.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\Test\UntypedArray;


use Ramsondon\UntypedArray\UntypedArray;

/**
 * Class UntypedArrayTest
 * @package Ramsondon\Test\UntypedArray
 */
class UntypedArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ramsondon\UntypedArray\UntypedArray
     */
    private $array;

    /**
     * @var array
     */
    private $values = array();

    public function setUp()
    {
        $this->array = new UntypedArray();

        $this->values = array(
            45,
            new \stdClass(),
            10,
            0,
            'foobar',
            'false'
        );
    }

    public function tearDown()
    {
        $this->array = null;
    }

    /**
     * ArrayExtensions
     */
    public function testAppendAndCountValue()
    {
        foreach ($this->values as $key => $value) {
            $this->assertEquals($key, count($this->array));
            $this->array->append($value);
        }

        $this->assertEquals(count($this->values), count($this->array));
    }

    public function testRemoveAtAndCountValue()
    {
        $this->assertFalse($this->array->removeAt(0));
        $this->array->append(45);
        $this->assertEquals(1, count($this->array));
        $this->assertTrue($this->array->removeAt(0));
        $this->assertFalse($this->array->removeAt(0));
        $this->assertEquals(0, count($this->array));
    }

    public function testGetAt()
    {
        foreach ($this->values as $key => $value) {
            $this->array->append($value);
        }

        $this->assertEquals(45, $this->array->getAt(0));
        $this->assertTrue(is_object($this->array->getAt(1)));
        $this->assertEquals(10, $this->array->getAt(2));
        $this->assertEquals(0, $this->array->getAt(3));
        $this->assertEquals('foobar', $this->array->getAt(4));
    }

    public function testIterate()
    {
        $this->applyValues();

        foreach ($this->array as $key => $value) {
            $this->assertEquals($this->values[$key], $value);
        }
    }

    public function testIterateAppend()
    {
        $valIndex = 2;
        $this->applyValues();

        $this->values[] = $this->values[$valIndex];

        $count = 0;
        foreach ($this->array as $key => $value) {
            if ($key == $valIndex) {
                $this->array->append($value);
            }
            $count++;
        }
        $this->assertEquals($count, count($this->array));
        $this->assertEquals(count($this->values), count($this->array));

        foreach ($this->values as $key => $value) {
            $this->assertEquals($value, $this->array->getAt($key));
        }

        $this->assertEquals($this->values[$valIndex], $this->array->getAt(count($this->values)-1));
    }

    public function testIterateRemoveAtSamePosition()
    {
        $this->applyValues();
        $valIndex = 3;
        $removeAt = 3;

        $values = array();
        foreach ($this->array as $key => $value) {
            if ($key == $valIndex) {
                $this->assertTrue($this->array->removeAt($removeAt));
            }

            $values[] = $this->array->getAt($key);
        }

        foreach ($values as $k => $v) {
            $found = (($k == $removeAt) ? true : false);
            if (!$found) {
                foreach ($this->array as $ak => $av) {
                    if ($av === $v) {
                        $found = true;
                        break;
                    }
                }
            }
            $this->assertTrue($found);
        }

        $this->assertEquals($this->values[0], $this->array->getAt(0));
        $this->assertEquals($this->values[1], $this->array->getAt(1));
        $this->assertEquals($this->values[2], $this->array->getAt(2));
        $this->assertEquals($this->values[4], $this->array->getAt(3));
        $this->assertEquals($this->values[5], $this->array->getAt(4));

        $this->assertEquals(count($this->values) - 1, count($this->array));
    }

    public function testIterateRemoveAtSmallerPosition()
    {
        $this->applyValues();
        $valIndex = 3;
        $removeAt = 1;
        $values = array();
        foreach ($this->array as $key => $value) {
            if ($key == $valIndex) {
                $this->assertTrue($this->array->removeAt($removeAt));
                $this->assertTrue($this->array->removeAt($removeAt));
            }
            $this->assertEquals($this->values[$key],$value);

            $values[] = $this->array->getAt($key);
        }

        foreach ($values as $k => $v) {
            $found = (($k == $removeAt || $k == $removeAt+1) ? true : false);
            if (!$found) {
                foreach ($this->array as $ak => $av) {
                    if ($av === $v) {
                        $found = true;
                        break;
                    }
                }
            }
            $this->assertTrue($found);
        }

        $this->assertEquals($this->values[0], $this->array->getAt(0));
        $this->assertEquals($this->values[3], $this->array->getAt(1));
        $this->assertEquals($this->values[4], $this->array->getAt(2));
        $this->assertEquals($this->values[5], $this->array->getAt(3));


        $this->assertEquals(count($this->values)-2, count($this->array));



    }

    public function testIterateRemoveAtGreaterPosition()
    {
        $this->applyValues();
        $valIndex = 2;
        $removeAt = 3;
        $values = array();
        foreach ($this->array as $key => $value) {

            if ($key == $valIndex) {
                $this->assertTrue($this->array->removeAt($removeAt));
            }

            $values[] = $this->array->getAt($key);
        }

        $this->assertEquals(count($this->values)-1, count($this->array));

        $this->assertEquals($this->values[0], $this->array->getAt(0));
        $this->assertEquals($this->values[1], $this->array->getAt(1));
        $this->assertEquals($this->values[2], $this->array->getAt(2));
        $this->assertEquals($this->values[4], $this->array->getAt(3));
        $this->assertEquals($this->values[5], $this->array->getAt(4));

        foreach ($values as $k => $v) {
            $found = (($k == $removeAt) ? true : false);
            if (!$found) {
                foreach ($this->array as $ak => $av) {
                    if ($av === $v) {
                        $found = true;
                        break;
                    }
                }
            }
            $this->assertTrue($found);
        }
    }

    private function applyValues()
    {
        foreach ($this->values as $value) {
            $this->array->append($value);
        }
    }
}