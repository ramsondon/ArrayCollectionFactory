<?php
/**
 * ArrayCollectionBase.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\TypedArray\Generate\Base;


use Ramsondon\UntypedArray\UntypedArray;

/**
 * Class ArrayCollectionBase
 * @package Ramsondon\TypedArray\Generate\Base
 */
abstract class ArrayCollectionBase
{
    /**
     * @var \Ramsondon\UntypedArray\UntypedArray
     */
    protected $impl;

    /**
     * Base Implementation
     */
    public function __construct()
    {
        $this->impl = new UntypedArray();
    }
}