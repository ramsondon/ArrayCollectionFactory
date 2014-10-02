ArrayCollectionFactory
=============

ArrayCollectionFactory is a dynamic ArrayCollection generator for type save access via type hints in PHP5.

the ArrayCollection implements \Countable, \Iterator and the dynamically created cached ArrayCollection contains
the methods:

    ->append(Class\of\Object $object);

    ->getAt($index);

    ->removeAt($index);

    try phpunit in directory src/Ramsondon/TypedArray/Test to generate cached ArrayCollection and Interface.
    the cached files will be created in src/Ramsondon/TypedArray/Cache

How to use:
===========

```php
    use Ramsondon\ArrayCollectionFactory;

    $factroy = new ArrayCollectionFactory();

    /* @var $collection \Ramsondon\TypedArray\Cache\ITestObjectArrayCollection */
    $collection = $factory->create('Class\\Of\\TestObject');

    $object = new Class\Of\TestObject();

    $collection->append($object);

    /* @var $testobject \Class\Of\TestObject */
    foreach ($collection as $testobject) {
        $testobject->doSomething();
    }


```

