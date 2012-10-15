<?php

namespace Emicro\Bundles\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($request->isMethod('POST')) {

            $email = $this->getRequest()->request->get('email');
            $password = $this->getRequest()->request->get('password');

            $user = $this->getDoctrine()->getRepository('EmicroCoreBundle:User')->login($email, $password);

            if ($user !== false) {
                $this->get('session')->set('user', $user);
                return $this->redirect('/app');
            }
        }

        return $this->render('EmicroCoreBundle:Auth:login.html.twig');
    }

    public function logoutAction()
    {
        $this->get('session')->set('user', null);
        $this->get('session')->setFlash('success', '<i class="icon-ok"></i>&nbsp; You have successfully been logged out.');

        return $this->redirect('/');
    }
}