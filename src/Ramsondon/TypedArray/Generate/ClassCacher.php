<?php
/**
 * ClassCacher.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\TypedArray\Generate;


use Ramsondon\TypedArray\Generate\Exceptions\ClassCacherGenerationException;
use Ramsondon\TypedArray\Generate\Templates\TemplateCreator;
use Ramsondon\TypedArray\Generate\Templates\TemplateObject;

/**
 * Class ClassCacher
 * @package Ramsondon\TypedArray\Generate
 */
class ClassCacher
{
    /**
     * @var string
     */
    private $namspace;

    /**
     * @var string
     */
    private $classsuffix = 'ArrayCollection';


    /**
     * @param string $namespace
     */
    public function __construct($namespace)
    {
        $this->namspace = $namespace;
    }

    /**
     * @param string $classname
     * @return \Iterator
     * @throws Exceptions\ClassCacherGenerationException
     */
    public function get($classname)
    {
        if ( ! is_string($classname)) {
            throw new ClassCacherGenerationException('expected string as input');
        }

        $cachedclassname = $this->createCachedClassName($classname);

        if ( ! $this->lookup($cachedclassname)) {
            if ( ! $this->create($cachedclassname, $classname)) {
                throw new ClassCacherGenerationException('the class could not be created');
            }
        }

        return new $cachedclassname();
    }

    /**
     * @param string $classname
     * @return string
     */
    private function extractNamespace($classname)
    {
        $path = explode('\\', $classname);
        if ( ! empty($path) ) {
            array_pop($path);
            return ltrim(implode('\\', $path), '\\');
        }
        return '';
    }

    /**
     * @param string $classname
     * @return string
     */
    private function extractClass($classname)
    {
        $path = explode('\\', $classname);
        return array_pop($path);
    }

    /**
     * @param string $classname
     * @return string
     */
    private function createCachedClassName($classname)
    {
        return sprintf('%s\%s%s', $this->namspace, $this->extractClass($classname), $this->classsuffix);
    }

    /**
     * @param string $classname
     * @return bool
     */
    private function lookup($classname)
    {
        return class_exists($classname, true);
    }

    /**
     * @param string $cachedclassname
     * @param string $classname
     * @return bool
     */
    private function create($cachedclassname, $classname)
    {
        $cachedclassname = $this->extractClass($cachedclassname);

        $template = $this->createTemplateObject($cachedclassname, $classname);

        $creator = new TemplateCreator($template);
        $result = $creator->create();

        $this->autoload($template, $cachedclassname);

        return $result;
    }

    /**
     * registers autoloader for new cached files
     *
     * @param TemplateObject $template
     * @param string $cachedclassname
     */
    private function autoload(TemplateObject $template, $cachedclassname)
    {

        $interfacename = ltrim($this->namspace . '\\I' . $cachedclassname, '\\');
        $classname = ltrim($this->namspace . '\\' . $cachedclassname, '\\');

        spl_autoload_register(function ($class) use ($template, $interfacename, $classname) {

            $filename = null;
            if ($class == $interfacename) {
                $filename = $template->getInterfaceFile();
            } else if ($class == $classname) {
                $filename = $template->getClassFile();
            }

            if ( ! empty($filename) && is_readable($filename)) {
                require_once $filename;
            }


        });
    }

    /**
     * @param string $cachedclassname
     * @param string $objectclassname
     * @return TemplateObject
     */
    private function createTemplateObject($cachedclassname, $objectclassname)
    {
        $config = new TemplateObject();

        date_default_timezone_set('UTC');
        $now = new \DateTime();
        $config->set(TemplateObject::_DATE, $now->format('m/d/Y'));

        $config->set(TemplateObject::_FILENAME, $cachedclassname . '.php');
        $config->set(TemplateObject::_CLASSNAME, $cachedclassname);
        $config->set(TemplateObject::_PARENTCLASS, '\\Ramsondon\\TypedArray\\Generate\\Base\\ArrayCollectionBase');
        $config->set(TemplateObject::_OBJECTCLASS, $this->extractClass($objectclassname));
        $config->set(TemplateObject::_USING, ltrim($objectclassname, '\\'));
        $config->set(TemplateObject::_NAMESPACE, ltrim($this->namspace, '\\'));

        return $config;
    }
}