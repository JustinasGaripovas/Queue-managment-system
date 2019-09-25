<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @CustomIdGenerator(class="App\Utilities\QueueIdGenerator")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interestField;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QueueTaskStatusLog", mappedBy="queueTask", orphanRemoval=true, cascade={"persist"})
     */
    private $statusList;

    public function __construct()
    {
        $this->statusList = new ArrayCollection();
    }

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

    /**
     * @return Collection|QueueTaskStatusLog[]
     */
    public function getStatusList(): Collection
    {
        return $this->statusList;
    }

    public function addStatus($status)
    {
        $statusObject = new QueueTaskStatusLog();
        $currentDate = new\DateTime('now');

        $statusObject->setStatus($status);
        $statusObject->setCreatedAt($currentDate->getTimestamp());

        $this->addStatusList($statusObject);
    }

    public function addStatusList(QueueTaskStatusLog $statusList): self
    {
        if (!$this->statusList->contains($statusList)) {
            $this->statusList[] = $statusList;
            $statusList->setQueueTask($this);
        }

        return $this;
    }

    public function removeStatusList(QueueTaskStatusLog $statusList): self
    {
        if ($this->statusList->contains($statusList)) {
            $this->statusList->removeElement($statusList);
            // set the owning side to null (unless already changed)
            if ($statusList->getQueueTask() === $this) {
                $statusList->setQueueTask(null);
            }
        }

        return $this;
    }
}
