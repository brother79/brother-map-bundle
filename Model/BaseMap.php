<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.07.2015
 * Time: 14:40
 */

namespace Brother\MapBundle\Model;


use Brother\CommonBundle\AppDebug;

abstract class BaseMap
{

    protected $params;

    function __construct($params)
    {
        $this->params = $params;
    }

    public function getParam($name, $default = null)
    {
        return empty($this->params[$name]) ? $default : $this->params[$name];
    }

    public function getHtmlId()
    {
        return $this->getParam('html_id', 'ymap');
    }

    public function getLatitude()
    {
        return $this->getParam('latitude');
    }

    public function getLongitude()
    {
        return $this->getParam('longitude');
    }

    public abstract function getType();

    public abstract function getZoom();

} 