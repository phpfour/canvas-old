<?php

namespace Emicro\Bundles\CoreBundle\Service\Serializer;

class Json implements SerializerInterface
{
    public function serialize($entity)
    {
        return json_encode($entity->toArray());
    }
}