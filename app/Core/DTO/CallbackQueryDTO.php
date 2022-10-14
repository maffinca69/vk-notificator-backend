<?php

namespace App\Core\DTO;

class CallbackQueryDTO
{
    private string $id;

    private FromDTO $from;

    private MessageDTO $message;

    private string $chatInstance;

    private string $data;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CallbackQueryDTO
     */
    public function setId(string $id): CallbackQueryDTO
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return FromDTO
     */
    public function getFrom(): FromDTO
    {
        return $this->from;
    }

    /**
     * @param FromDTO $from
     * @return CallbackQueryDTO
     */
    public function setFrom(FromDTO $from): CallbackQueryDTO
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return MessageDTO
     */
    public function getMessage(): MessageDTO
    {
        return $this->message;
    }

    /**
     * @param MessageDTO $message
     * @return CallbackQueryDTO
     */
    public function setMessage(MessageDTO $message): CallbackQueryDTO
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getChatInstance(): string
    {
        return $this->chatInstance;
    }

    /**
     * @param string $chatInstance
     * @return CallbackQueryDTO
     */
    public function setChatInstance(string $chatInstance): CallbackQueryDTO
    {
        $this->chatInstance = $chatInstance;

        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return CallbackQueryDTO
     */
    public function setData(string $data): CallbackQueryDTO
    {
        $this->data = $data;

        return $this;
    }
}
