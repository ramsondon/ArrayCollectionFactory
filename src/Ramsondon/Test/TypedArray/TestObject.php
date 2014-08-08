<?php
/**
 * TestObject.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\Test\TypedArray;


/**
 * Class TestObject
 *
 * test object for generating generic collections
 *
 * @package Ramsondon\Test\TypedArray
 */
class TestObject
{
    /**
     * @var string
     */
    private $string;

    /**
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }
}