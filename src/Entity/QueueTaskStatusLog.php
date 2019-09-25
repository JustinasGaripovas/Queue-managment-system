<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QueueTaskStatusLogRepository")
 */
class QueueTaskStatusLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QueueTask", inversedBy="statusList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $queueTask;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getQueueTask(): ?QueueTask
    {
        return $this->queueTask;
    }

    public function setQueueTask(?QueueTask $queueTask): self
    {
        $this->queueTask = $queueTask;

        return $this;
    }
}
