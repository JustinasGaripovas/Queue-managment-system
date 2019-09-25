<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\CustomIdGenerator;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QueueTaskRepository")
 */
class QueueTask
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="App\")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interestField;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInterestField(): ?string
    {
        return $this->interestField;
    }

    public function setInterestField(?string $interestField): self
    {
        $this->interestField = $interestField;

        return $this;
    }
}
