<?php

namespace Emicro\Bundles\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function login($email, $password)
    {
        $user = $this->findOneBy(array('email' => $email, 'password' => $this->hash($password)));
        return $user;
    }

    private function hash($string)
    {
        return sha1($string);
    }
}
