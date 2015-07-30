<?php
namespace Brother\MapBundle\Model\Factory;
use Brother\CommonBundle\AppDebug;
use Brother\MapBundle\Model\Map\YMap;

/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 30.07.2015
 * Time: 16:05
 */

class MapFactory {

    const MAP_TYPE_YANDEX = 'yandex';

    /**
     * @param $mapType
     * @param array $params
     * - map:{html_id, type, zoom }
     * - controls: []
     * - point: {title, title_style: (twirl#pinkStretchyIcon), latitude, longitude}
     * - polygon: [points: {}]
     * @return \Brother\MapBundle\Model\Map\YMap
     */
    static function create($mapType, $params=array())
    {
        switch ($mapType) {
            default:
                AppDebug::_dx($mapType);
            case self::MAP_TYPE_YANDEX: return new YMap($params);
        }
    }
} 