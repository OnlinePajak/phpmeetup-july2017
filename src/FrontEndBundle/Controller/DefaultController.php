<?php

namespace FrontEndBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('meetup.api.user')->fetchUser(1);
        $user = $user["data"][0];

        $items = $this->get('meetup.api.item')->fetchAllItems();
        $items = $items["data"];

        return $this->render('FrontEndBundle:Default:index.html.twig' , array(
            "items" => $items,
            "user" => $user
        ));
    }
}
