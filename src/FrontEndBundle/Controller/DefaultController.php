<?php

namespace FrontEndBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $items = $this->get('meetup.api.item')->fetchAllItems();
        Debug::dump($items);exit;
        
        return $this->render('FrontEndBundle:Default:index.html.twig' , array(
            "items" => $items
        ));
    }
}
