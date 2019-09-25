<?php

namespace App\Utilities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class QueueIdGenerator extends AbstractIdGenerator
{
    /**
     * Generates an identifier for an entity.
     *
     * @param EntityManager $em
     * @param object|null   $entity
     *
     * @return mixed
     */
    public function generate(EntityManager $em, $entity)
    {
        dump($entity);
        die;

        // TODO: Implement generate() method.
    }
}
