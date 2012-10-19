<?php

namespace Emicro\Bundles\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Emicro\Bundles\CoreBundle\Entity\User;
use Emicro\Bundles\CoreBundle\Entity\Project;

class ProjectRepository extends EntityRepository
{
    /** @var User */
    protected $user;

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function insert($data)
    {
        $project = $this->map($data);

        $this->_em->persist($project);
        $this->_em->flush();

        return $project;
    }

    protected function map($data, $project = null)
    {
        if (is_null($project)) {
            $project = new Project();
        }

        $fields = array('title', 'details');

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $project->{"set{$field}"}($data[$field]);
            }
        }

        $project->setUser($this->user);

        return $project;
    }
}
