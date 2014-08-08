<?php
/**
 * TemplateCreator.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\TypedArray\Generate\Templates;

/**
 * Class TemplateCreator
 * @package Ramsondon\TypedArray\Generate\Templates
 */
class TemplateCreator
{
    /**
     * @var \Ramsondon\TypedArray\Generate\Templates\TemplateObject
     */
    private $config;

    /**
     * @param \Ramsondon\TypedArray\Generate\Templates\TemplateObject $object
     */
    public function __construct(TemplateObject $object)
    {
        $this->config = $object;
    }

    /**
     * Creates the Implementation of Classes in PHP Files
     */
    public function create()
    {
        $this->createInterfaceTemplate();
        $this->createClassTemplate();

        return true;
    }

    /**
     * creates the interface
     */
    private function createInterfaceTemplate()
    {
        $content = $this->read($this->config->getInterfaceTemplate());
        $content = $this->config->replace($content);
        $filename = $this->config->getInterfaceFile();
        $this->write($filename, $content);

        return true;
    }

    /**
     * creates the class template for the new specific typehinted ArrayCollection
     */
    private function createClassTemplate()
    {
        $content = $this->read($this->config->getClassTemplate());
        $content = $this->config->replace($content);
        $this->write($this->config->getClassFile(), $content);

        return true;
    }

    /**
     * @param string $filename
     * @return string
     */
    private function read($filename)
    {
        return file_get_contents($filename);
    }

    /**
     * @param string $filename
     * @param string $content
     */
    private function write($filename, $content)
    {
        file_put_contents($filename, $content);
    }
}