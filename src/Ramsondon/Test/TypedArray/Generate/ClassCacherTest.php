<?php
/**
 * ClassCacheFactoryTest.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\Test\TypedArray\Generate;


use Ramsondon\Test\TypedArray\TestObject;
use Ramsondon\TypedArray\Generate\ClassCacher;

class ClassCacherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClassCacher
     */
    private $cacher;

    public function setUp()
    {
        $this->cacher = new ClassCacher('\Ramsondon\TypedArray\Cache');
    }

    public function tearDown()
    {
        $this->cacher = null;
    }

    public function testGet()
    {
       $collection = $this->createTestObjectCollection();

        $values = array(
            'foobar',
            'baz',
            'bar',
            'foo'
        );

        foreach ($values as $value) {
            $collection->append(new TestObject($value));
        }

        $this->assertEquals(4, count($collection));

        $this->assertEquals($values[0], $collection->getAt(0)->getString());
        $this->assertEquals($values[1], $collection->getAt(1)->getString());
        $this->assertEquals($values[2], $collection->getAt(2)->getString());
        $this->assertEquals($values[3], $collection->getAt(3)->getString());


        foreach ($collection as $key => $object) {
            $this->assertTrue(($object instanceof \Ramsondon\Test\TypedArray\TestObject));
            $this->assertEquals($values[$key], $collection->getAt($key)->getString());
        }

        $collection->removeAt(0);
        $this->assertEquals($values[1], $collection->getAt(0)->getString());


    }

    public function testGetWrongInputParamStdClass()
    {
        $collection = $this->createTestObjectCollection();

        $this->setExpectedException('\Exception');
        $collection->append(new \stdClass());
    }

    public function testGetWrongInputParamInteger()
    {
        $collection = $this->createTestObjectCollection();

        $this->setExpectedException('\Exception');
        $collection->append(3945);
    }

    public function testGetWrongInputParamString()
    {
        $collection = $this->createTestObjectCollection();

        $this->setExpectedException('\Exception');
        $collection->append('Input shall be a \\Ramsondon\Test\\TypedArray\\TestObject');
    }


    public function testExtractNamespace()
    {
        $result = $this->invokeMethod($this->cacher, 'extractNamespace', array('\\Ramsondon\\Foobar\\Baz\\TestClass'));
        $this->assertEquals('Ramsondon\\Foobar\\Baz', $result);

        $result = $this->invokeMethod($this->cacher, 'extractNamespace', array('TestClass'));
        $this->assertEquals('', $result);

        $result = $this->invokeMethod($this->cacher, 'extractNamespace', array('\Hero\Forno\ClassTest'));
        $this->assertEquals('Hero\\Forno', $result);
    }

    public function testExtractClass()
    {
        $result = $this->invokeMethod($this->cacher, 'extractClass', array('\Ramsondon\Foobar\Baz\TestClass'));
        $this->assertEquals('TestClass', $result);

        $result = $this->invokeMethod($this->cacher, 'extractClass', array('TestClass'));
        $this->assertEquals('TestClass', $result);

        $result = $this->invokeMethod($this->cacher, 'extractClass', array('\\Hero\\Forno\\ClassTest'));
        $this->assertEquals('ClassTest', $result);
    }

    public function testCreateNamespace()
    {
        $classname = 'Foobar';
        $result = $this->invokeMethod($this->cacher, 'createCachedClassName', array($classname));

        $this->assertEquals('\Ramsondon\TypedArray\Cache\FoobarArrayCollection', $result);
    }

    /**
     * @return \Ramsondon\TypedArray\Cache\ITestObjectArrayCollection
     */
    private function createTestObjectCollection()
    {
        /* @var $collection \Ramsondon\TypedArray\Cache\ITestObjectArrayCollection */
        $collection = $this->cacher->get('\\Ramsondon\\Test\\TypedArray\\TestObject');

        $this->assertEquals(
            'Ramsondon\\TypedArray\\Cache\\TestObjectArrayCollection',
            get_class($collection)
        );

        return $collection;
    }

    /**
     * @param $object
     * @param $method
     * @param array $params
     */
    private function invokeMethod($object, $method, array $params)
    {
        $ref = new \ReflectionClass($object);
        $method = $ref->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($this->cacher, $params);
    }
}