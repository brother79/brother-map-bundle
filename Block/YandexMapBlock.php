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
use Symfony\Component\Security\Core\SecurityContextInterface;

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
     * @param SecurityContextInterface $securityContext
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
        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
            'context' => $blockContext,
            'settings' => $blockContext->getSettings(),
            'block' => $blockContext->getBlock(),

        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        // TODO: Implement validateBlock() method.
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('title', 'text', array('required' => false, 'data' => 'Yandex map')),
                array('latitude', 'number', array('required' => true, 'data' => $this->config['latitude'])),
                array('longitude', 'number', array('required' => true, 'data' => $this->config['longitude'])),
                array('map_type', 'choice', array('required' => true, 'data' => $this->config['type'], 'choices' => array(
                    YMap::MAP_TYPE_HYBRID => 'Гибрит',
                    YMap::MAP_TYPE_MAP => 'Схема',
                    YMap::MAP_TYPE_PUBLIC => 'Народная',
                    YMap::MAP_TYPE_PUBLIC_HYBRID => 'Народная гибрит',
                    YMap::MAP_TYPE_SATELLITE => 'Спутник'
                ))),
                array('map_zoom', 'integer', array('required' => true, 'data' => $this->config['zoom'])),
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
        $resolver->setDefaults(array(
            'title' => 'Yandex map',
            'template' => 'BrotherMapBundle:Block:yandex_map.html.twig',
            'context' => 'GLOBAL',
//            'filter'          => true,
//            'paginate'        => true,
        ));
    }
}
