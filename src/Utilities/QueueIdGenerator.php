<?php

namespace App\Utilities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class QueueIdGenerator extends AbstractIdGenerator
{
    /**
     * Generates an identifier for an entity.
     */
    public function generate(EntityManager $em, $entity)
    {
        dump($entity);

        return 1;
        // TODO: Implement generate() method.
    }
}
