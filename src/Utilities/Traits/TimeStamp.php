<?php


namespace App\Utilities\Traits;


use DateTime;

trait TimeStamp
{
    /**
     * @var integer $createdAt
     *
     * @ORM\Column(name="created_at", type="integer")
     */
    private $createdAt;

    /**
     * @var integer $updatedAt
     *
     * @ORM\Column(name="updated_at", type="integer")
     */
    private $updatedAt;

    /**
     * @var bool $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", options={"default" : 1})
     */
    private $isActive = true;

    /**
     * @ORM\PrePersist
     * @ORM\PostPersist
     */
    public function persistTimestamps(): void
    {
        $currentDate = new \DateTime('now');

        $this->updatedAt = $currentDate->getTimestamp();
        if ($this->createdAt === null) {
            $this->createdAt = $currentDate->getTimestamp();
        }
    }
}