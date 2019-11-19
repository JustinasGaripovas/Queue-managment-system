<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeDeskRepository")
 */
class EmployeeDesk
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeDeskQueueTaskLog", mappedBy="employeeDesk")
     */
    private $employeeDeskQueueTaskLogs;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Employee", inversedBy="employeeDesk", cascade={"persist", "remove"})
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QueueTaskStatusLog", mappedBy="employeeDesk")
     */
    private $queueTaskStatusLogs;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inUse = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOnline = false;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\QueueTask", inversedBy="employeeDesk", cascade={"persist", "remove"})
     */
    private $queueTask;

    public function __construct()
    {
        $this->employeeDeskQueueTaskLogs = new ArrayCollection();
        $this->queueTaskStatusLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|EmployeeDeskQueueTaskLog[]
     */
    public function getEmployeeDeskQueueTaskLogs(): Collection
    {
        return $this->employeeDeskQueueTaskLogs;
    }

    public function addEmployeeDeskQueueTaskLog(EmployeeDeskQueueTaskLog $employeeDeskQueueTaskLog): self
    {
        if (!$this->employeeDeskQueueTaskLogs->contains($employeeDeskQueueTaskLog)) {
            $this->employeeDeskQueueTaskLogs[] = $employeeDeskQueueTaskLog;
            $employeeDeskQueueTaskLog->setEmployeeDesk($this);
        }

        return $this;
    }

    public function removeEmployeeDeskQueueTaskLog(EmployeeDeskQueueTaskLog $employeeDeskQueueTaskLog): self
    {
        if ($this->employeeDeskQueueTaskLogs->contains($employeeDeskQueueTaskLog)) {
            $this->employeeDeskQueueTaskLogs->removeElement($employeeDeskQueueTaskLog);

            // set the owning side to null (unless already changed)
            if ($employeeDeskQueueTaskLog->getEmployeeDesk() === $this) {
                $employeeDeskQueueTaskLog->setEmployeeDesk(null);
            }
        }

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return Collection|QueueTaskStatusLog[]
     */
    public function getQueueTaskStatusLogs(): Collection
    {
        return $this->queueTaskStatusLogs;
    }

    public function addQueueTaskStatusLog(QueueTaskStatusLog $queueTaskStatusLog): self
    {
        if (!$this->queueTaskStatusLogs->contains($queueTaskStatusLog)) {
            $this->queueTaskStatusLogs[] = $queueTaskStatusLog;
            $queueTaskStatusLog->setEmployeeDesk($this);
        }

        return $this;
    }

    public function removeQueueTaskStatusLog(QueueTaskStatusLog $queueTaskStatusLog): self
    {
        if ($this->queueTaskStatusLogs->contains($queueTaskStatusLog)) {
            $this->queueTaskStatusLogs->removeElement($queueTaskStatusLog);
            // set the owning side to null (unless already changed)
            if ($queueTaskStatusLog->getEmployeeDesk() === $this) {
                $queueTaskStatusLog->setEmployeeDesk(null);
            }
        }

        return $this;
    }

    public function getInUse(): ?bool
    {
        return $this->inUse;
    }

    public function setInUse(bool $inUse): self
    {
        $this->inUse = $inUse;

        return $this;
    }

    public function getIsOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline(bool $isOnline): self
    {
        $this->isOnline = $isOnline;

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
