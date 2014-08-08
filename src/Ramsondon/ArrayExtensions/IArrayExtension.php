<?php
/**
 * IArrayExtension.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\ArrayExtensions;

/**
 * Interface IArrayExtension
 * @package Ramsondon\ArrayExtensions
 */
interface IArrayExtension extends \Iterator, \Countable
{
    /**
     * Appends a new $value to the end of the IArrayExtension
     *
     * @param mixed $value
     */
    public function append($value);

    /**
     * Removes the element at the $index and returns true on success. false on failure
     *
     * @param int $index
     * @return bool
     */
    public function removeAt($index);

    /**
     * Returns the value at $index or null on failure
     *
     * @param int $index
     * @return mixed|null on failure
     */
    public function getAt($index);
}