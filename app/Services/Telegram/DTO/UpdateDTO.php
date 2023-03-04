<?php

namespace App\Services\Telegram\DTO;

class UpdateDTO
{
    private int $id;

    private ?MessageDTO $message = null;

    private ?CallbackQueryDTO $callbackQuery = null;

    private string $json = '';

    /**
     * @return array
     */
    public function getJson(): array
    {
        return !empty($this->json) ? json_decode($this->json, true) : [];
    }

    /**
     * @param array $params
     */
    public function setJson(array $params): void
    {
        $this->json = json_encode($params);
    }

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return CallbackQueryDTO|null
     */
    public function getCallbackQuery(): ?CallbackQueryDTO
    {
        return $this->callbackQuery;
    }

    /**
     * @param CallbackQueryDTO|null $callbackQuery
     */
    public function setCallbackQuery(?CallbackQueryDTO $callbackQuery): void
    {
        $this->callbackQuery = $callbackQuery;
    }

    /**
     * @return MessageDTO|null
     */
    public function getMessage(): ?MessageDTO
    {
        return $this->message;
    }

    /**
     * @param MessageDTO|null $message
     */
    public function setMessage(?MessageDTO $message): void
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getChatId(): ?int
    {
        $message = $this->getMessage() ?? $this->getCallbackQuery()->getMessage();
        if ($message) {
            return $message->getChat()->getId();
        }

        return null;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return $this->json ?: '';
    }

}
