<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brother\MapBundle\Block;

use Brother\MapBundle\Model\Options\PresetStorage;
use Brother\MapBundle\Model\Shape\GeoObject;
use Brother\MapBundle\Model\Shape\Point;
use Brother\MapBundle\Model\YMap;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author     Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class YandexMapBlock extends BaseBlockService
{
    private $config;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param $config
     */
    public function __construct($name, EngineInterface $templating, $config)
    {
        $this->config = $config;
        parent::__construct($name, $templating);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        // merge settings
        $map = new YMap($blockContext->getSettings());
        if (!empty($settings['point']['title'])) {
            $map->addObject(new Point(
                $settings['point']['latitude'],
                $settings['point']['longitude'],
                array(GeoObject::PROPERTY_ICON_CONTENT => $settings['point']['title']),
                array(GeoObject::OPTION_PRESET => empty($settings['point']['title_style']) ? 'twirl#pinkStretchyIcon' : $settings['point']['title_style'])
            ));
        }

        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
            'context' => $blockContext,
            'settings' => $blockContext->getSettings(),
            'block' => $blockContext->getBlock(),
            'map' => $map
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
//        $errorElement
//            ->with('settings.html_id')->assertNotNull(array())->assertNotBlank()->end()
//            ->with('settings.latitude')->assertNotNull(array())->assertNotBlank()->end()
//            ->with('settings.longitude')->assertNotNull(array())->assertNotBlank()->end()
//            ->with('settings.map_type')->assertNotNull(array())->assertNotBlank()->end()
//            ->with('settings.map_zoom')->assertNotNull(array())->assertNotBlank()->end();
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $settings = $block->getSettings();
        $formMapper
            ->add('settings', 'sonata_type_immutable_array', array(
                'translation_domain' => 'BrotherMapBundle',
                'keys' => array(
                    array('map', 'sonata_type_immutable_array', array('keys' => array(
                        array('html_id', 'text', array(
                            'required' => true,
                            'data' => empty($settings['map']['html_id']) ? 'ymap' : $settings['map']['html_id'])),
                        array('type', 'choice', array(
                            'required' => true,
                            'data' => empty($settings['map']['type']) ? $this->config['type'] : $settings['map']['type'],
                            'choices' => array(
                                YMap::MAP_TYPE_HYBRID => 'Гибрит',
                                YMap::MAP_TYPE_MAP => 'Схема',
                                YMap::MAP_TYPE_PUBLIC => 'Народная',
                                YMap::MAP_TYPE_PUBLIC_HYBRID => 'Народная гибрит',
                                YMap::MAP_TYPE_SATELLITE => 'Спутник'
                            ))),
                        array('zoom', 'choice', array(
                            'required' => true,
                            'data' => empty($settings['map']['zoom']) ? $this->config['zoom'] : $settings['map']['zoom'],
                            'choices' => array(
                                1 => 'Мелко', 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8,
                                9 => 'Средне', 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15,
                                16 => 'Крупно'
                            ))),
                    ))),
                    array('point', 'sonata_type_immutable_array', array('keys' => array(
                        array('title', 'text', array('required' => false)),
                        array('title_style', 'choice', array(
                            'required' => false,
                            'choices' => PresetStorage::$stretchIcons)),
                        array('latitude', 'number', array(
                            'required' => true,
                            'data' => empty($settings['point']['latitude']) ? $this->config['latitude'] : $settings['point']['latitude'],
                            'precision' => 6)),
                        array('longitude', 'number', array(
                            'required' => true,
                            'data' => empty($settings['point']['longitude']) ? $this->config['longitude'] : $settings['point']['longitude'],
                            'precision' => 6)),
                    ))),
                    array('polygon', 'sonata_type_immutable_array', array('keys' => array(
                        array('points', 'text', array('required' => false)),
                        array(GeoObject::OPTION_STROKE_WIDTH, 'text', array('required' => false)),
                        array(GeoObject::OPTION_STROKE_COLOR, 'text', array('required' => false)),
                        array(GeoObject::OPTION_OPACITY, 'text', array('required' => false)),
                    )))

                )));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Yandex map';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'map' => array(
                'html_id' => 'ymap',
                'latitude' => $this->config['latitude'],
                'longitude' => $this->config['longitude'],
                'type' => $this->config['type'],
                'zoom' => $this->config['zoom'],
            ),
            'point' => array(
                'title' => null,
                'title_style' => null,
            ),
            'polygon' => array(),
            'template' => 'BrotherMapBundle:Block:yandex_map.html.twig',
            'context' => 'GLOBAL',
        ));
    }

}
