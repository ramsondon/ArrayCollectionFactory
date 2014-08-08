<?php
/**
 * ClassCacheFactoryTest.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\Test\TypedArray\Templates;


use Ramsondon\TypedArray\Generate\Templates\TemplateObject;

class TemplateObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClassCacher
     */
    private $object;

    public function setUp()
    {
        $config = new TemplateObject();

        $cachedclassname = '\\Ramsondon\\TypedArray\\Cache\\TestObjectArrayCollection';
        $objectclassname = '\\Ramsondon\\Test\\TypedArray\\TestObject';

        date_default_timezone_set('UTC');
        $now = new \DateTime();
        $config->set(TemplateObject::_DATE, $now->format('m/d/Y'));

//        $config->set(TemplateObject::_FILENAME, $cachedclassname . '.php');
//        $config->set(TemplateObject::_CLASSNAME, $this->extractClass($cachedclassname));
//        $config->set(TemplateObject::_PARENTCLASS, 'ArrayCollectionBase');
//        $config->set(TemplateObject::_OBJECTCLASS, $this->extractClass($objectclassname));
//        $config->set(TemplateObject::_USING, $this->extractNamespace($objectclassname));
//        $config->set(TemplateObject::_NAMESPACE, '\\Ramsondon\\TypedArray\\Cache');

        $this->object = $config;
    }

    public function tearDown()
    {
        $this->object = null;
    }

    public function testFoo()
    {
        $key = '$FILENAME$';
        $subject = 'älkajsdflksjdf $FILENAME$ $lkajsdflkjsdf';
        $replacement = 'JEDE';
        $result = 'älkajsdflksjdf JEDE $lkajsdflkjsdf';

        $this->assertEquals($result, str_replace($key, $replacement, $subject));


    }

    public function testGetWritePath()
    {
        $this->assertNotFalse($this->invokeMethod($this->object, 'getWritePath', array()));
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

        return $method->invokeArgs($object, $params);
    }
}