<?php

namespace Emicro\Bundles\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Emicro\Bundles\CoreBundle\Entity\User;
use Emicro\Bundles\CoreBundle\Entity\Canvas;
use Emicro\Bundles\CoreBundle\Entity\Project;

class CanvasRepository extends EntityRepository
{
    /** @var User */
    protected $user;

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getByUser($userId)
    {
        $dql = 'SELECT c
                FROM Emicro\Bundles\CoreBundle\Entity\Canvas c
                JOIN c.user u
                WHERE c.project IS NULL
                AND u.id = ' . $userId;

        $query = $this->_em->createQuery($dql);
        $results = $query->getResult();

        $canvases = array();

        if ($results) {
            foreach ($results as $canvas) {
                $canvases[] = $canvas;
            }
        }

        return $canvases;
    }

    public function insert($data)
    {
        $canvas = $this->map($data);

        $this->_em->persist($canvas);
        $this->_em->flush();

        return $canvas;
    }

    public function update($data, $id)
    {
        $canvas = $this->find($id);

        if (is_null($canvas)) {
            return false;
        }

        $canvas = $this->map($data, $canvas);

        $this->_em->persist($canvas);
        $this->_em->flush();

        return $canvas;
    }

    protected function map($data, $canvas = null)
    {
        if (is_null($canvas)) {
            $canvas = new Canvas();
        }

        $fields = array('title', 'image', 'markers', 'details', 'canvasHeight', 'canvasWidth');

        foreach ($fields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $canvas->{"set{$field}"}($data[$field]);
            }
        }

        if (isset($data['project_id'])) {
            $projectRepo = $this->getEntityManager()->getRepository('Emicro\Bundles\CoreBundle\Entity\Project');
            $canvas->setProject($projectRepo->find($data['project_id']));
        }

        $canvas->setUser($this->user);

        return $canvas;
    }
}
