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

    public function register($data)
    {
        $user = $this->findOneBy(array('email' => $data['email']));

        if (is_null($user)) {
            $data['password'] = $this->hash($data['password']);
            $user = $this->insert($data);
        }

        return $user;
    }

    public function insert($data)
    {
        $user = $this->map($data);

        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }

    protected function map($data, $user = null)
    {
        if (is_null($user)) {
            $user = new User();
        }

        $fields = array('email', 'password', 'firstName', 'lastName');

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $user->{"set{$field}"}($data[$field]);
            }
        }

        return $user;
    }

    private function hash($string)
    {
        return sha1($string);
    }
}