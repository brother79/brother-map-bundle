<?php

namespace Brother\MapBundle\Model\Shape;

/**
 * Created by JetBrains PhpStorm.
 * User: Администратор
 * Date: 29.09.12
 * Time: 21:30
 * To change this template use File | Settings | File Templates.
 */
class GeoObject
{
    const TYPE_POINT = 'Point'; // точка
    const TYPE_POLYGON = 'Polygon'; // полигон [[точки][точки]]
    const TYPE_LINE_STRING = 'LineString'; // линия [точки]
    const TYPE_RECTANGLE = 'Rectangle'; // прямоугольник [точка1, точка2]

    const PROPERTY_BALLOON_CONTENT = 'balloonContent'; // содержимое балуна по клику на объект
    const PROPERTY_BALLOON_CONTENT_HEADER = 'balloonContentHeader'; // 'Заголовок',
    const PROPERTY_BALLOON_CONTENT_BODY = 'balloonContentBody'; // 'Содержимое <em>балуна</em>',
    const PROPERTY_BALLOON_CONTENT_FOOTER = 'balloonContentFooter'; // 'Подвал'
    const PROPERTY_ICON_CONTENT = 'iconContent'; // текст внутри иконки(point)
    const PROPERTY_HINT_CONTENT = 'hintContent'; // текст хинта

    const OPTION_STROKE_COLOR = 'stokeColor'; // Цвет линии
    const OPTION_STROKE_WIDTH = 'strokeWidth'; // толщина линии
    const OPTION_STROKE_STYLE = 'strokeStyle'; // 'shortdash'
    const OPTION_OPACITY = 'opacity'; // прозрачность
    const OPTION_PRESET = 'preset'; // например растягивание иконки по тексту
    CONST OPTION_CURSOR = 'cursor'; // 'grab', // курсор на метках будет "рукой"
    const OPTION_DRAGGABLE = 'draggable'; // перемешение объекта мышкой
    const OPTION_ICON_IMAGE_HREF = 'iconImageHref'; // картинка иконки
    const OPTION_ICON_IMAGE_SIZE = 'iconImageSize'; // [30, 42] размеры картинки
    const OPTION_ICON_IMAGE_OFFSET = 'iconImageOffset'; // [-3, -42] смещение картинки
    const OPTION_ICON_LAYOUT = 'iconLayout'; //:"default#imageWithContent", // Указываем, что макет иконки будет с контентом
    const OPTION_ICON_CONTENT_OFFSET = 'iconContentOffset'; //[33, 53]  // Пиксельный сдвиг содержимого иконки относительно родительского элемента
    const OPTION_BALLOON_SHADOW = 'balloonShadow';
    const OPTION_BALLOON_LAYOUT = 'balloonLayout'; // "default#imageWithContent" Задаем макет балуна - пользовательская картинка с контентом
    const OPTION_BALLOON_IMAGE_HREF = 'balloonImageHref'; // Картинка балуна
    const OPTION_BALLOON_IMAGE_OFFSET = 'balloonImageOffset'; // [70, -130] Смещение картинки балуна
    const OPTION_BALLOON_IMAGE_SIZE = 'balloonImageSize'; // [120, 100] Размеры картинки балуна
    const OPTION_HIDE_ICON_ON_BALLOON_OPEN = 'hideIconOnBalloonOpen'; // false Не скрывать иконку метки при открытии балуна

    const PRESET_BLUE_STRETCHY_ICON = 'twirl#blueStretchyIcon'; // растягивать иконку по тексту внутри
    const PRESET_CAFE_ICON = 'twirl#cafeIcon'; // Иконка кафе
    const ICON_LAYOUT_IMAGE_WITH_CONTENT = 'default#imageWithContent'; // Указываем, что макет иконки будет с контентом

    /**
     * @var String тип фигуры
     */
    protected $type;
    protected $coordinates;
    protected $properties;
    protected $options;

//myGeoObject = new ymaps.GeoObject({geometry: {type: "Point",coordinates: [55.8, 37.8]}});
    function __construct($type, $coordinates, $properties = array(), $options = array())
    {
        $this->type = $type;
        $this->coordinates = $coordinates;
        $this->properties = $properties;
        $this->options = $options;
    }

    public function renderYandex()
    {
        $geometry = '{type:"' . $this->type . '",coordinates:' . $this->renderCoordinates($this->coordinates) . '}';
        $properties = $this->renderProperies();
        $options = $this->renderOptions();
        return '{geometry:' . $geometry . ',properties:' . $properties . '},' . $options;
    }

    private function renderCoordinates($values)
    {
        if (isset($values['longitude'])) {
            return '[' . $values['latitude'] . ',' . $values['longitude'] . ']';
        } else {
            $r = array();
            foreach ($values as $coo) {
                $r[] = $this->renderCoordinates($coo);
            }
            return '[' . implode(',', $r) . ']';
        }
    }

    private function renderArray($values)
    {
        $r = array();
        foreach ($values as $k => $v) {
            $r[] = $k . ':' . '"' . str_replace('"', '\"', $v) . '"';
        }
        return '{' . implode(',', $r) . '}';
    }

    private function renderProperies()
    {
        return $this->renderArray($this->properties);
    }

    private function renderOptions()
    {
        return $this->renderArray($this->options);
    }

}
