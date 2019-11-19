<?php

namespace App\Entity;

use App\Utilities\Traits\LogTrait;
use App\Utilities\Traits\TimeStamp;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeDeskQueueTaskLogRepository")
 */
class EmployeeDeskQueueTaskLog
{
    use TimeStamp;
    use LogTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmployeeDesk", inversedBy="employeeDeskQueueTaskLogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employeeDesk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QueueTask")
     */
    private $queueTask;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="employeeDeskQueueTaskLogs")
     */
    private $employee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeDesk(): ?EmployeeDesk
    {
        return $this->employeeDesk;
    }

    public function setEmployeeDesk(?EmployeeDesk $employeeDesk): self
    {
        $this->employeeDesk = $employeeDesk;

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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }
}
