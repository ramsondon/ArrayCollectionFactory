<?php
/**
 * UntypedArray.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\UntypedArray;
use Ramsondon\ArrayExtensions\IArrayExtension;

/**
 * Class UntypedArray
 * @package Ramsondon\UntypedArray
 */
class UntypedArray implements IArrayExtension
{
    /**
     * @var array
     */
    private $container = array();

    /**
     * @var int
     */
    private $current = 0;

    /**
     * @var int
     */
    private $count = 0;

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
//        if (array_key_exists($this->current, $this->container)) {
            return $this->container[$this->current];
//        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->current++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        if ( ! $this->valid()) {
            return null;
        }

        return $this->current;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        if ( empty($this->container) || ! array_key_exists($this->current, $this->container)) {
            return false;
        }

        return true;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->current = 0;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return (int) $this->count;
    }

    /**
     * Appends a new $value to the end of the IArrayExtension
     *
     * @param mixed $value
     */
    public function append($value)
    {
        $this->container[] = $value;
        $this->count++;
    }

    /**
     * Removes the element at the $index and returns true on success. false on failure
     *
     * @param int $index
     * @return bool
     */
    public function removeAt($index)
    {
        if (array_key_exists($index, $this->container)) {
            unset($this->container[$index]);
            $this->container = array_values($this->container);
            $this->count--;
            return true;
        }

        return false;
    }

    /**
     * Returns the value at $index or null on failure
     *
     * @param int $index
     * @return mixed|null on failure
     */
    public function getAt($index)
    {
        if (array_key_exists($index, $this->container)) {
            return $this->container[$index];
        }

        return null;
    }

}