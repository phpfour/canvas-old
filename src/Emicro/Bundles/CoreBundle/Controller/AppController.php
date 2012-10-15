<?php

namespace Emicro\Bundles\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        if($this->get('session')->get('user') === null) {
            return $this->redirect('/login');
        }

        $user = $this->get('session')->get('user');
        $userJson = json_encode($user->toArray());

        return $this->render('EmicroCoreBundle:App:index.html.twig', array(
            'user' => $user,
            'userJson' => $userJson
        ));
    }
}
