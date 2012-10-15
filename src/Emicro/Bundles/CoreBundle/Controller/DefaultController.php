<?php

namespace Emicro\Bundles\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EmicroCoreBundle:Default:index.html.twig');
    }
}
