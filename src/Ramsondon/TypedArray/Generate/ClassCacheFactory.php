<?php
/**
 * ClassCacheFactory.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\TypedArray\Generate;

/**
 * Class ClassCacheFactory
 * @package Ramsondon\TypedArray\Generate
 */
class ClassCacheFactory
{
    /**
     * @param string $namespace
     * @return ClassCacher
     */
    public function create($namespace)
    {
        return new ClassCacher($namespace);
    }
}