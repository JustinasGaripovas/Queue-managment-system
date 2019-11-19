<?php


namespace App\Response\QueueResponse;


use App\Response\AbstractResponse;

class QueueTaskNoAvalibleNumbersResponse extends AbstractResponse
{
    /**
     * @var string
     */
    private $message;

    public function __construct(string $message = 'The queue is fully filled, please wait.')
    {
        $this->message = $message;

        parent::__construct();
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'response' => [
                "error_code" => "02",
                "error_message" => $this->message,
            ]
        ];
    }

    /**
     * @return int
     */
    protected function status(): int
    {
        return 410;
    }
}