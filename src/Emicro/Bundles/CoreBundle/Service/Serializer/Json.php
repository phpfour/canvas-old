<?php

namespace Emicro\Bundles\CoreBundle\Service\Serializer;

class Json implements SerializerInterface
{
    public function serialize($entity)
    {
        if (!is_array($entity)) {
            $data = $entity->toArray();
        } else {
            $data = array();
            foreach ($entity as $singleEntity) {
                $data[] = $singleEntity->toArray();
            }
        }

        return json_encode($data);
    }
}