<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterestTypeRepository")
 */
class InterestType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestType", inversedBy="subType")
     */
    private $interestType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InterestType", mappedBy="interestType")
     */
    private $subType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QueueTask", mappedBy="interestType", orphanRemoval=true)
     */
    private $queueTasks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Employee", mappedBy="interestType")
     */
    private $employees;

    public function __construct()
    {
        $this->subType = new ArrayCollection();
        $this->queueTasks = new ArrayCollection();
        $this->employees = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->fullName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getInterestType(): ?self
    {
        return $this->interestType;
    }

    public function setInterestType(?self $interestType): self
    {
        $this->interestType = $interestType;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubType(): Collection
    {
        return $this->subType;
    }

    public function addSubType(self $subType): self
    {
        if (!$this->subType->contains($subType)) {
            $this->subType[] = $subType;
            $subType->setInterestType($this);
        }

        return $this;
    }

    public function removeSubType(self $subType): self
    {
        if ($this->subType->contains($subType)) {
            $this->subType->removeElement($subType);
            // set the owning side to null (unless already changed)
            if ($subType->getInterestType() === $this) {
                $subType->setInterestType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QueueTask[]
     */
    public function getQueueTasks(): Collection
    {
        return $this->queueTasks;
    }

    public function addQueueTask(QueueTask $queueTask): self
    {
        if (!$this->queueTasks->contains($queueTask)) {
            $this->queueTasks[] = $queueTask;
            $queueTask->setInterestType($this);
        }

        return $this;
    }

    public function removeQueueTask(QueueTask $queueTask): self
    {
        if ($this->queueTasks->contains($queueTask)) {
            $this->queueTasks->removeElement($queueTask);
            // set the owning side to null (unless already changed)
            if ($queueTask->getInterestType() === $this) {
                $queueTask->setInterestType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->addInterestType($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            $employee->removeInterestType($this);
        }

        return $this;
    }
}
