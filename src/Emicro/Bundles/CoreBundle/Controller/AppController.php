<?php

namespace Emicro\Bundles\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Emicro\Bundles\CoreBundle\Service\Serializer\Json as JsonSerializer;

class AppController extends Controller
{
    public function indexAction()
    {
        if ($this->get('session')->get('user') === null) {
            return $this->redirect('/login');
        }

        $user = $this->get('session')->get('user');

        $canvasRepo = $this->getDoctrine()->getRepository('Emicro\Bundles\CoreBundle\Entity\Canvas');
        $canvases = $canvasRepo->getByUser($user->getId());

        $serializer = new JsonSerializer();

        return $this->render('EmicroCoreBundle:App:index.html.twig', array(
            'user' => $user,
            'userJson' => $serializer->serialize($user),
            'canvases' => $serializer->serialize($canvases)
        ));
    }
}
