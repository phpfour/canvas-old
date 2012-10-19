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
        $response = new Response();

        if ($this->get('session')->get('user') === null) {
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('response' => Response::$statusTexts[401])));
            return $response;
        }

        $data = $this->getRequest()->request->all();
        $data['image'] = $this->handleUpload();

        $canvasRepo = $this->getDoctrine()->getRepository('Emicro\Bundles\CoreBundle\Entity\Canvas');

        if (isset($data['id'])) {
            $canvas = $canvasRepo->update($data, $data['id']);
            $response->setStatusCode(200);
        } else {
            $canvas = $canvasRepo->insert($data);
            $response->setStatusCode(201);
        }

        $serializer = new JsonSerializer();
        $response->setContent($serializer->serialize($canvas));

        return $response;
    }

    private function handleUpload()
    {
        $uploadDir = './uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777);
        }

        if (empty($_FILES)) {
            return false;
        }

        $uploadedFile = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile);

        $imageResizer = new ImageResizer($uploadedFile);
        $imageResizer->maxWidth(300)->resize();

        return basename($_FILES['image']['name']);
    }
}
