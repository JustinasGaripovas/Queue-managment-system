<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee implements UserInterface
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $workingSince;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeDeskQueueTaskLog", mappedBy="employee")
     */
    private $employeeDeskQueueTaskLogs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EmployeeDesk", mappedBy="employee", cascade={"persist", "remove"})
     */
    private $employeeDesk;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\InterestType", inversedBy="employees")
     */
    private $interestType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QueueTaskStatusLog", mappedBy="employee")
     */
    private $queueTaskStatusLogs;

    /**
     * @Assert\NotBlank()
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $encodedPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    public function __construct()
    {
        $this->employeeDeskQueueTaskLogs = new ArrayCollection();
        $this->interestType = new ArrayCollection();
        $this->queueTaskStatusLogs = new ArrayCollection();

        $this->roles = ['ROLE_EMPLOYEE'];

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(?bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getWorkingSince(): ? int
    {
        return $this->workingSince;
    }

    public function setWorkingSince(int $workingSince): self
    {
        $this->workingSince = $workingSince;

        return $this;
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
            $employeeDeskQueueTaskLog->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeDeskQueueTaskLog(EmployeeDeskQueueTaskLog $employeeDeskQueueTaskLog): self
    {
        if ($this->employeeDeskQueueTaskLogs->contains($employeeDeskQueueTaskLog)) {
            $this->employeeDeskQueueTaskLogs->removeElement($employeeDeskQueueTaskLog);
            // set the owning side to null (unless already changed)
            if ($employeeDeskQueueTaskLog->getEmployee() === $this) {
                $employeeDeskQueueTaskLog->setEmployee(null);
            }
        }

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
        $newEmployee = $employeeDesk === null ? null : $this;
        if ($newEmployee !== $employeeDesk->getEmployee()) {
            $employeeDesk->setEmployee($newEmployee);
        }

        return $this;
    }

    public function getInterestType()
    {
        return $this->interestType;
    }

    public function addInterestType(InterestType $interestType): self
    {
        if (!$this->interestType->contains($interestType)) {
            $this->interestType[] = $interestType;
        }

        return $this;
    }

    public function removeInterestType(InterestType $interestType): self
    {
        if ($this->interestType->contains($interestType)) {
            $this->interestType->removeElement($interestType);
        }

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
            $queueTaskStatusLog->setEmployee($this);
        }

        return $this;
    }

    public function removeQueueTaskStatusLog(QueueTaskStatusLog $queueTaskStatusLog): self
    {
        if ($this->queueTaskStatusLogs->contains($queueTaskStatusLog)) {
            $this->queueTaskStatusLogs->removeElement($queueTaskStatusLog);
            // set the owning side to null (unless already changed)
            if ($queueTaskStatusLog->getEmployee() === $this) {
                $queueTaskStatusLog->setEmployee(null);
            }
        }

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getEncodedPassword(): ?string
    {
        return $this->encodedPassword;
    }

    public function setEncodedPassword(string $encodedPassword): self
    {
        $this->encodedPassword = $encodedPassword;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        return $this->encodedPassword;
    }

    public function setPassword($password)
    {
        $this->encodedPassword = $password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
