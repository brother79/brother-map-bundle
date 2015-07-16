<?php

namespace Brother\MapBundle\Model;

/**
 * Created by JetBrains PhpStorm.
 * User: Администратор
 * Date: 21.04.12
 * Time: 22:34
 * To change this template use File | Settings | File Templates.
 */
class YMap extends BaseMap
{
    const MAP_TYPE_HYBRID = 'yandex#hybrid'; //		Тип карты - "Гибрид".
    const MAP_TYPE_MAP = 'yandex#map'; //	Тип карты - "Схема".
    const MAP_TYPE_SATELLITE = 'yandex#satellite'; // 		Тип карты - "Спутник".
    const MAP_TYPE_PUBLIC_HYBRID = 'yandex#publicMapHybrid'; // (гибрид народной карты)
    const MAP_TYPE_PUBLIC = 'yandex#publicMap'; // (народная карта);

    const BEHAVIOR_DEFAULT = 'default';    // По умолчанию
    const BEHAVIOR_SCROLL_ZOOM = 'scrollZoom'; // масштабирование колесом мыши
    const BEHAVIOR_DRAG = 'drag'; // таскание карты левой кнопкой
    const BEHAVIOR_RIGHT_MOUSE_BUTTON_MAGNIFIER = 'rightMouseButtonMagnifier'; // увеличение карты по правой кнопке мыши
    const BEHAVIOR_RULER = 'ruler'; // измеритель расстояний, активирующийся при щелчке левой кнопкой мыши.

    const OPTION_GEO_OBJECT_DRAGGABLE = 'geoObjectDraggable'; // true  все геообъекты, размещенные на карте, можно перемещать
    const OPTION_GEO_OBJECT_FILL_COLOR = 'geoObjectFillColor';// '#ffffff' все многоугольники будут закрашены белым цветом
    const OPTION_GEO_OBJECT_BALLOON_CLOSE_BUTTON = 'balloonCloseButton'; // false -  у балунов не будет кнопки закрытия
    const OPTION_SCROLL_ZOOM_SPEED = 'scrollZoomSpeed'; // скорость масштабирования

    const CONTROL_ZOOM = 'zoomControl'; // Кнопка изменения масштаба
    const CONTROL_TYPE_SELECTOR = 'typeSelector'; // Список типов карты
    const CONTROL_ZOOM_SMALL = 'smallZoomControl'; // { right: 5, top: 75 }) моленький контрол масштаба
    const CONTROL_MAP_TOOLS = 'mapTools';
    const CONTROL_SCALE_LINE = 'scaleLine';
    const CONTROL_MINI_MAP = 'miniMap'; // TODO
    /*
// Также в метод add можно передать экземпляр класса, реализующего определенный элемент управления.
// Например, линейка масштаба ('scaleLine')
            myMap.controls
                .add(new ymaps.control.ScaleLine())
                // В конструкторе элемента управления можно задавать расширенные
                // параметры, например, тип карты в обзорной карте
                .add(new ymaps.control.MiniMap({
                    type: 'yandex#publicMap'
    */

    public function renderControls()
    {
        $r = array();
        foreach ($this->getControls() as $k => $control) {
            if (is_string($control)) {
                $k = $control;
                $control = array();
            }
            switch ($k) {
                default:
                    $c = json_encode($control/*, JSON_FORCE_OBJECT*/); // #todo закоментировал для пхп <5.3
                    $r[] = '.add("' . $k . '"' . (count($control) == 0 ? '' : ',' . $c) . ')';
                    break;
            }
        }
        return count($r) ? 'map.controls' . implode('', $r) . ';' : '';

    }

    private function getControls()
    {
        return isset($this->params['controls']) ? $this->params['controls'] : array();
    }


    public function getType()
    {
        return $this->getParam('map_type', self::MAP_TYPE_HYBRID);
    }

    public function getZoom()
    {
        return $this->getParam('map_zoom', 12);
    }
}
