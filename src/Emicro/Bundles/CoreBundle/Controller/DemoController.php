<?php

namespace Emicro\Bundles\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DemoController extends Controller
{
    public function indexAction()
    {
        $user = new \Emicro\Bundles\CoreBundle\Entity\User();

        $user->setEmail('test@emicrograph.com');
        $user->setPassword(sha1('123456'));
        $user->setFirstName('Test');
        $user->setLastName('User');
        $user->setCreateDate(new \DateTime());
        $user->setUpdateDate(new \DateTime());

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        \Doctrine\Common\Util\Debug::dump($user);
        die;
    }
}