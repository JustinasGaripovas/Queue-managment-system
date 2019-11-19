<?php


namespace App\Response\QueueResponse;


use App\Response\AbstractResponse;

class QueueTaskNewSuccessResponse extends AbstractResponse
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $data;

    public function __construct(string $message, array $data = null)
    {
        $this->message = $message;
        $this->data = $data;

        parent::__construct();
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'response' => [
                "error_code" => "00",
                "error_message" => $this->message,
            ],
            'data' => $this->data

        ];
    }

    /**
     * @return int
     */
    protected function status(): int
    {
        return 200;
    }
}