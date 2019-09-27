<?php

namespace App\Entity;

use App\Utilities\Enum\QueueTaskStatusEnum;
use App\Utilities\StateSwitch\QueueTaskStateSwitch;
use App\Utilities\Traits\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\CustomIdGenerator;


/**
 * @ORM\Entity(repositoryClass="App\Repository\QueueTaskRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class QueueTask extends QueueTaskStateSwitch
{
    use TimeStamp;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interestField;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QueueTaskStatusLog", mappedBy="queueTask", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $statusList;

    /**
     * @ORM\Column(type="integer")
     */
    private $queueNumber;

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

    public function getQueueNumber(): ?int
    {
        return $this->queueNumber;
    }

    public function setQueueNumber(int $queueNumber): self
    {
        $this->queueNumber = $queueNumber;

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

        if ($this->getNewestStatusList() === -1){
            $statusObject->setStatus(QueueTaskStatusEnum::NEW);
            $this->addStatusList($statusObject);
        }

        if ($this->canSwitchState($this->getNewestStatusList(), $status))
        {
            $statusObject->setStatus($status);
            $this->addStatusList($statusObject);
        }else{
            // TODO: Return state mismatch exception
            return $this;
        }

        return $this;
    }

    public function getNewestStatusList()
    {
        $statusObject = $this->statusList->last() ;

        if ($statusObject === false)
            return -1;
        else
            return $statusObject->getStatus();
    }

    public function addStatusList(QueueTaskStatusLog $statusList): self
    {
        $currentDate = new\DateTime('now');
        $statusList->setCreatedAt($currentDate->getTimestamp());

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
