<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.07.2015
 * Time: 14:40
 */

namespace Brother\MapBundle\Model\Map;

abstract class BaseMap
{

    protected $params;

    function __construct($params=array())
    {
        $this->params = $params;
    }

    public function getHtmlId()
    {
        return $this->getParam('html_id', 'ymap', 'map');
    }

    public function getParam($name, $default = null, $group=null)
    {
        if ($group && isset($this->params[$group][$name])) {
            return $this->params[$group][$name];
        }
        return empty($this->params[$name]) ? $default : $this->params[$name];
    }

    public function getLatitude()
    {
        return $this->getParam('latitude', null, 'point');
    }

    public function getLongitude()
    {
        return $this->getParam('longitude', null, 'point');
    }

    public abstract function getType();

    public abstract function getZoom();

    public function addObject($object)
    {
        $this->params['objects'][] = $object;
    }

    public function addControl($control)
    {
        $this->params['controls'][] = $control;
    }

    public function getObjects()
    {
        return isset($this->params['objects']) ? $this->params['objects'] : array();
    }

    protected function getControls()
    {
        return isset($this->params['controls']) ? $this->params['controls'] : array();
    }
} 