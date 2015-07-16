<?php

namespace Brother\MapBundle\Model\Shape;

/**
 * Created by JetBrains PhpStorm.
 * User: Администратор
 * Date: 29.09.12
 * Time: 21:19
 * To change this template use File | Settings | File Templates.
 */
class Point extends GeoObject
{
    function __construct($latitude, $longitude, $properties = array(), $options = array())
    {
        parent::__construct(self::TYPE_POINT,
            array('longitude' => $longitude, 'latitude' => $latitude),
        $properties, $options);
    }
}
