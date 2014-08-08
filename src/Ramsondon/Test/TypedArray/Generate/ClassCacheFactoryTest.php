<?php
/**
 * ClassCacheFactoryTest.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\Test\TypedArray\Generate;


use Ramsondon\TypedArray\Generate\ClassCacheFactory;
use Ramsondon\TypedArray\Generate\ClassCacher;

class ClassCacheFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClassCacheFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new ClassCacheFactory();
    }

    public function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateClassCacher()
    {
        $cacher = $this->factory->create('\Ramsondon\TypedArray\Cache');
        $this->assertTrue(($cacher instanceof ClassCacher));
    }
}