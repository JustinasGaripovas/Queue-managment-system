<?php

namespace App\Utilities\Traits;

trait LogTrait
{
    /**
     * @var integer $message
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=false)
     */
    private $message;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;
}