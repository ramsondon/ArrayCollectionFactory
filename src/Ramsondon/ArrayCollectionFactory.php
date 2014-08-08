<?php
/**
 * ArrayCollectionFactoryctory.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon;

use Ramsondon\TypedArray\TypedArrayFactory;

/**
 * Class ArrayCollectionFactory
 *
 * the public interface
 *
 * @package Ramsondon
 */
class ArrayCollectionFactory extends TypedArrayFactory
{
    /**
     * This method returns your type hinted array collection for a random Object
     * The return value will be an object of type \Ramsondon\TypedArray\Cache\<CLASSNAME>ArrayCollection
     *
     * @param string $classname
     */
    public function create($classname)
    {
        return parent::create($classname);
    }
}