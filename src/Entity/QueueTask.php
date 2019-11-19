<?php

namespace App\Entity;

use App\Exception\QueueTaskException\StateSwitchException;
use App\Utilities\Enum\QueueTaskStatusEnum;
use App\Utilities\StateSwitch\QueueTaskStateSwitch;
use App\Utilities\Traits\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\QueueTaskRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"isActive", "queueNumber"},
 *     errorPath="queueNumber",
 *     message="This number is already in use."
 * )
 */
class QueueTask extends QueueTaskStateSwitch
{
    use TimeStamp;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QueueTaskStatusLog", mappedBy="queueTask", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $statusList;

    /**
     * @ORM\Column(type="integer")
     */
    private $queueNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestType", inversedBy="queueTasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $interestType;

    /**
     * @ORM\Column(type="boolean", options={"default" : 1})
     */
    private $isQueueNumberInUse=true;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EmployeeDesk", mappedBy="queueTask", cascade={"persist", "remove"})
     */
    private $employeeDesk;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isComplete = false;

    public function __construct()
    {
        $this->statusList = new ArrayCollection();

        $this->setIsQueueNumberInUse(true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormattedQueueNumber(): ?string
    {
        if ($this->getQueueNumber() <= 9)
            return "{$this->getInterestType()->getId()}0{$this->getQueueNumber()}";
        else
            return "{$this->getInterestType()->getId()}{$this->getQueueNumber()}";
    }

    public function getQueueNumber(): ?int
    {
        return $this->queueNumber;
    }

    public function setQueueNumber(int $queueNumber): self
    {
        $this->queueNumber = $queueNumber;

        $this->isActive = true;

        return $this;
    }

    /**
     * @return Collection|QueueTaskStatusLog[]
     */
    public function getStatusList(): Collection
    {
        return $this->statusList;
    }

    public function addStatus($status,EmployeeDesk $employeeDesk = null, Employee $employee = null)
    {
        $statusObject = new QueueTaskStatusLog();

        $statusObject->setEmployee($employee);
        $statusObject->setEmployeeDesk($employeeDesk);

        if ($this->getNewestStatusList() === -1) {
            $statusObject->setStatus(QueueTaskStatusEnum::NEW);
            $this->addStatusList($statusObject);
            return $this;
        }

        if ($this->canSwitchState($this->getNewestStatusList(), $status)) {
            $statusObject->setStatus($status);
            $this->addStatusList($statusObject);
        } else {
//            throw new StateSwitchException();
        }

        return $this;
    }

    public function getNewestStatusList()
    {
        $statusObject = $this->statusList->first();

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

        if (in_array($statusList->getStatus(), QueueTaskStatusEnum::END)) {
            $this->isActive = false;
            $this->isComplete = true;
            $this->isQueueNumberInUse = false;
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

    public function getInterestType(): ?InterestType
    {
        return $this->interestType;
    }

    public function setInterestType(?InterestType $interestType): self
    {
        $this->interestType = $interestType;

        return $this;
    }

    public function getIsQueueNumberInUse(): ?bool
    {
        return $this->isQueueNumberInUse;
    }

    public function setIsQueueNumberInUse(bool $isQueueNumberInUse): self
    {
        $this->isQueueNumberInUse = $isQueueNumberInUse;

        return $this;
    }

    public function getEmployeeDesk(): ?EmployeeDesk
    {
        return $this->employeeDesk;
    }

    public function setEmployeeDesk(?EmployeeDesk $employeeDesk): self
    {
        $this->employeeDesk = $employeeDesk;

        // set (or unset) the owning side of the relation if necessary
        $newQueueTask = $employeeDesk === null ? null : $this;
        if ($newQueueTask !== $employeeDesk->getQueueTask()) {
            $employeeDesk->setQueueTask($newQueueTask);
        }

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setIsComplete(bool $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }
}
