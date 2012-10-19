<?php

namespace Emicro\Bundles\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Emicro\Bundles\CoreBundle\Service\Serializer\Json as JsonSerializer;

class ProjectController extends Controller
{
    public function createAction()
    {
        if ($this->get('session')->get('user') === null) {
            $response = new Response();
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('response' => Response::$statusTexts[401])));
            return $response;
        }

        $data = json_decode($this->getRequest()->getContent(), true);
        $user = $this->get('session')->get('user');

        $userRepo = $this->getDoctrine()->getRepository('Emicro\Bundles\CoreBundle\Entity\User');
        $projectRepo = $this->getDoctrine()->getRepository('Emicro\Bundles\CoreBundle\Entity\Project');

        $projectRepo->setUser($userRepo->find($user->getId()));
        $newProject = $projectRepo->insert($data);

        $serializer = new JsonSerializer();
        $response = new Response();

        $response->setStatusCode(200);
        $response->setContent($serializer->serialize($newProject));

        return $response;
    }
}
