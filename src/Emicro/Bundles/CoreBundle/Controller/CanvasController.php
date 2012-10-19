<?php

namespace Emicro\Bundles\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Emicro\Bundles\CoreBundle\Service\Serializer\Json as JsonSerializer;
use Emicro\Bundles\CoreBundle\Service\ImageResizer\ImageResizer;

class CanvasController extends Controller
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
        $data['image'] = $this->handleUpload();

        $canvasRepo = $this->getDoctrine()->getRepository('Emicro\Bundles\CoreBundle\Entity\Canvas');
        $newCanvas = $canvasRepo->insert($data);

        $serializer = new JsonSerializer();
        $response = new Response();

        $response->setStatusCode(200);
        $response->setContent($serializer->serialize($newCanvas));

        return $response;
    }

    private function handleUpload()
    {
        $uploadDir = './uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777);
        }

        $uploadedFile = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile);

        $imageResizer = new ImageResizer($uploadedFile);
        $imageResizer->maxWidth(300)->resize();

        return '/uploads/' . basename($_FILES['image']['name']);
    }
}
