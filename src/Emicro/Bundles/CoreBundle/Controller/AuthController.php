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

        $flash = $this->get('session')->getFlashBag()->get('result');
        return $this->render('EmicroCoreBundle:Auth:login.html.twig', array('flash' => $flash));
    }

    public function registerAction(Request $request)
    {
        if ($request->isMethod('POST')) {

            $data = $this->getRequest()->request->all();
            $user = $this->getDoctrine()->getRepository('EmicroCoreBundle:User')->register($data);

            if ($user !== false) {
                $this->get('session')->getFlashBag()->set('result', 'Your signup is successful. Please login below.');
                return $this->redirect('/login');
            }
        }

        return $this->render('EmicroCoreBundle:Auth:register.html.twig');
    }

    public function logoutAction()
    {
        $this->get('session')->set('user', null);
        $this->get('session')->setFlash('success', '<i class="icon-ok"></i>&nbsp; You have successfully been logged out.');

        return $this->redirect('/');
    }
}