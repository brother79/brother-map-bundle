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
        // merge settings
        $map = new YMap($blockContext->getSettings());

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
        $errorElement
            ->with('settings.html_id')->assertNotNull(array())->assertNotBlank()->end()
            ->with('settings.latitude')->assertNotNull(array())->assertNotBlank()->end()
            ->with('settings.longitude')->assertNotNull(array())->assertNotBlank()->end()
            ->with('settings.map_type')->assertNotNull(array())->assertNotBlank()->end()
            ->with('settings.map_zoom')->assertNotNull(array())->assertNotBlank()->end();
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('title', 'text', array('required' => false)),
                array('title_style', 'text', array('required' => false)),

                array('html_id', 'text', array('required' => true, 'data' => $block->getSetting('html_id', 'ymap'))),
                array('latitude', 'number', array('required' => true, 'data' => $block->getSetting('latitude', $this->config['latitude']), 'precision' => 6)),
                array('longitude', 'number', array('required' => true, 'data' => $block->getSetting('longitude', $this->config['longitude']), 'precision' => 6)),
                array('map_type', 'choice', array('required' => true, 'data' => $block->getSetting('map_type', $this->config['type']), 'choices' => array(
                    YMap::MAP_TYPE_HYBRID => 'Гибрит',
                    YMap::MAP_TYPE_MAP => 'Схема',
                    YMap::MAP_TYPE_PUBLIC => 'Народная',
                    YMap::MAP_TYPE_PUBLIC_HYBRID => 'Народная гибрит',
                    YMap::MAP_TYPE_SATELLITE => 'Спутник'
                ))),
                array('map_zoom', 'choice', array('required' => true, 'data' => $block->getSetting('map_zoom', $this->config['zoom']), 'choices' => array(
                    1 => 'Мелко', 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8,
                    9 => 'Средне', 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15,
                    16 => 'Крупно'
                ))),
            )
        ));
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
//        AppDebug::_dx($resolver->);
        $resolver->setDefaults(array(
			'title' => null,
			'title_style' => null,
            'template' => 'BrotherMapBundle:Block:yandex_map.html.twig',
            'context' => 'GLOBAL',
            'html_id' => 'ymap',
            'latitude' => $this->config['latitude'],
            'longitude' => $this->config['longitude'],
            'map_type' => $this->config['type'],
            'map_zoom' => $this->config['zoom'],
        ));
    }

}
