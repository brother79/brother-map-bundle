<?php

namespace Brother\MapBundle\Model\Shape;

/**
 * Created by JetBrains PhpStorm.
 * User: Администратор
 * Date: 29.09.12
 * Time: 21:15
 * To change this template use File | Settings | File Templates.
 */
class Polygon extends GeoObject
{
    function __construct($coordinates, $properties = array(), $options = array())
    {
        parent::__construct(self::TYPE_POLYGON, $coordinates, $properties, $options);
    }

}
