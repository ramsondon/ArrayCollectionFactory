<?php
/**
 * TemplateObject.php
 * copyright by Matthias Schmid <ramsondon@gmail.com>
 * Date: 08/08/14
 */

namespace Ramsondon\TypedArray\Generate\Templates;


class TemplateObject
{
    const _FILENAME     = '${FILENAME}';
    const _DATE         = '${DATE}';
    const _NAMESPACE    = '${NAMESPACE}';
    const _CLASSNAME    = '${CLASSNAME}';
    const _PARENTCLASS  = '${PARENTCLASSNAME}';
    const _OBJECTCLASS  = '${OBJECTCLASS}';
    const _USING        = '${USING}';

    /**
     * @var array
     */
    private $defaultconfig = array(
        self::_FILENAME     => null,
        self::_DATE         => null,
        self::_NAMESPACE    => null,
        self::_CLASSNAME    => null,
        self::_PARENTCLASS  => null,
        self::_OBJECTCLASS  => null,
        self::_USING        => null,
    );

    /**
     * @var array
     */
    private $config = array();

    /**
     * @param $var
     * @param $value
     */
    public function set($var, $value)
    {
        $this->config[$var] = $value;
    }

    /**
     * Replaces the $content with this TemplateObject variables
     * @return string
     */
    public function replace($content)
    {
        foreach ($this->defaultconfig as $key => $value) {
            $content = str_replace("${key}", $this->config[$key], $content);
        }

        return $content;
    }

    /**
     * @return string
     */
    public function getInterfaceFile()
    {
        return sprintf('%s/I%s', $this->getWritePath(), $this->getFilename());
    }

    /**
     * @return string
     */
    public function getClassFile()
    {
        return sprintf('%s/%s', $this->getWritePath(), $this->getFilename());
    }

    /**
     * @return string
     */
    public function getInterfaceTemplate()
    {
        return __DIR__ . '/interface.txt';
    }

    /**
     * @return string
     */
    public function getClassTemplate()
    {
        return __DIR__ . '/class.txt';
    }

    /**
     * @return string
     */
    private function getWritePath()
    {
        return realpath(__DIR__ . '/../../Cache');
    }

    /**
     * @return string
     */
    private function getFilename()
    {
        return $this->config[self::_FILENAME];
    }
}