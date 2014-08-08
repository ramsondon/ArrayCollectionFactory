<?php
/**
 * TypedArrayFactoryTest.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\Test\TypedArray;


use Ramsondon\TypedArray\TypedArrayFactory;

/**
 * Class TypedArrayFactoryTest
 * @package Ramsondon\Test\TypedArray
 */
class TypedArrayFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ramsondon\TypedArray\TypedArrayFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new TypedArrayFactory();
    }

    public function tearDown()
    {
        $this->factory = null;
    }

    public function testInputExceptionInputIsInteger()
    {
        $this->setExpectedException('Ramsondon\TypedArray\Exceptions\TypedArrayFactoryInputException');
        $this->factory->create(1345);
    }

    public function testInputExceptionInputIsObject()
    {
        $this->setExpectedException('Ramsondon\TypedArray\Exceptions\TypedArrayFactoryInputException');
        $this->factory->create(new \stdClass());
    }

    public function testInputExceptionClassNotExists()
    {
        $this->setExpectedException('Ramsondon\TypedArray\Exceptions\TypedArrayFactoryInputException');
        $this->factory->create('this_class_does_Not_exist');
    }
}