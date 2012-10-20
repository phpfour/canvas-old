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
        $response->headers->set('Content-type', 'application/json');

        if ($this->get('session')->get('user') === null) {
            $response->setStatusCode(401);
            $response->setContent(json_encode(array('response' => Response::$statusTexts[401])));
            return $response;
        }

        $data = $this->getRequest()->request->all();

        if (empty($data)) {
            $data = json_decode($this->getRequest()->getContent(), true);
        }

        $this->handleUpload($data);

        $userRepo = $this->getDoctrine()->getRepository('Emicro\Bundles\CoreBundle\Entity\User');
        $canvasRepo = $this->getDoctrine()->getRepository('Emicro\Bundles\CoreBundle\Entity\Canvas');

        $user = $this->get('session')->get('user');
        $canvasRepo->setUser($userRepo->find($user->getId()));

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

    private function handleUpload(&$data)
    {
        $uploadDir = './uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777);
        }

        if (empty($_FILES)) {
            return false;
        }

        $newFilename = time() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $originalFile = $uploadDir . $newFilename;
        $canvasFile = $uploadDir . 'canvas_' . $newFilename;
        $thumbFile = $uploadDir . 'thumb_' . $newFilename;

        move_uploaded_file($_FILES['image']['tmp_name'], $originalFile);
        copy($originalFile, $canvasFile);
        copy($originalFile, $thumbFile);

        $imageResizer = new ImageResizer($canvasFile);
        $imageResizer->maxWidth(700)->resize();

        $imageResizer = new ImageResizer($thumbFile);
        $imageResizer->maxWidth(160)->resize();

        $canvasDimensions = getimagesize($canvasFile);

        $data['image'] = $newFilename;
        $data['canvasWidth'] = $canvasDimensions[0];
        $data['canvasHeight'] = $canvasDimensions[1];
    }
}
