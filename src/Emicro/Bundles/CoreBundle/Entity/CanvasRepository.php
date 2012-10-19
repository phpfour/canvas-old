<?php

namespace Emicro\Bundles\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Emicro\Bundles\CoreBundle\Entity\Canvas;
use Emicro\Bundles\CoreBundle\Entity\Project;

class CanvasRepository extends EntityRepository
{
    public function insert($data)
    {
        $canvas = $this->map($data);

        $this->_em->persist($canvas);
        $this->_em->flush();

        return $canvas;
    }

    protected function map($data, $canvas = null)
    {
        if (is_null($canvas)) {
            $canvas = new Canvas();
        }

        $fields = array('title', 'image', 'markers');

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $canvas->{"set{$field}"}($data[$field]);
            }
        }

        if (isset($data['project_id'])) {
            $projectRepo = $this->getEntityManager()->getRepository('Emicro\Bundles\CoreBundle\Entity\Project');
            $canvas->setProject($projectRepo->find($data['project_id']));
        }

        return $canvas;
    }
}
