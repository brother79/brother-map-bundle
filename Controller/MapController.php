<?php

namespace Brother\MapBundle\Controller;

use Brother\MapBundle\Model\YMap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function initYandexAction()
    {
        $map = new YMap(array());
        return $this->render('BrotherMapBundle:Map:index.html.twig', array(
            'map' => $map,
        ));
    }
}
