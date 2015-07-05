<?php

namespace Brother\MapBundle\Controller;

use Brother\MapBundle\Model\YMap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function initYandexAction()
	{
        $this->map = new YMap(array());

}
}
