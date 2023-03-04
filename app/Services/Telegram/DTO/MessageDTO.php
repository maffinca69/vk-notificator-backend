<?php

namespace App\Services\Telegram\DTO;

class MessageDTO
{
    private int $id;

    private int $date;

    private string $text;

    private array $entities;

    private ?CommandDTO $command;

    private ?StickerDTO $sticker;

    private FromDTO $from;

    private ChatDTO $chat;

    private ?ReplyMessageDTO $replyMessage;

    private ?ReplyMarkupDTO $replyMarkup;

    private ?PhotoDTO $photo;

    private ?MessageDTO $pinnedMessage;

    /**
     * @return MessageDTO|null
     */
    public function getPinnedMessage(): ?MessageDTO
    {
        return $this->pinnedMessage;
    }

    /**
     * @param MessageDTO|null $pinnedMessage
     */
    public function setPinnedMessage(?MessageDTO $pinnedMessage): void
    {
        $this->pinnedMessage = $pinnedMessage;
    }

    /**
     * @return PhotoDTO|null
     */
    public function getPhoto(): ?PhotoDTO
    {
        return $this->photo;
    }

    /**
     * @param PhotoDTO|null $photo
     *
     * @return MessageDTO
     */
    public function setPhoto(?PhotoDTO $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return ReplyMarkupDTO|null
     */
    public function getReplyMarkup(): ?ReplyMarkupDTO
    {
        return $this->replyMarkup;
    }

    /**
     * @param ReplyMarkupDTO|null $replyMarkup
     * @return MessageDTO
     */
    public function setReplyMarkup(?ReplyMarkupDTO $replyMarkup): MessageDTO
    {
        $this->replyMarkup = $replyMarkup;

        return $this;
    }

    /**
     * @return ReplyMessageDTO|null
     */
    public function getReplyMessage(): ?ReplyMessageDTO
    {
        return $this->replyMessage;
    }

    /**
     * @param ReplyMessageDTO|null $replyMessage
     */
    public function setReplyMessage(?ReplyMessageDTO $replyMessage): void
    {
        $this->replyMessage = $replyMessage;
    }

    /**
     * @return StickerDTO|null
     */
    public function getSticker(): ?StickerDTO
    {
        return $this->sticker;
    }

    /**
     * @param StickerDTO|null $sticker
     */
    public function setSticker(?StickerDTO $sticker): void
    {
        $this->sticker = $sticker;
    }

    /**
     * @return CommandDTO|null
     */
    public function getCommand(): ?CommandDTO
    {
        return $this->command;
    }

    /**
     * @param CommandDTO|null $command
     */
    public function setCommand(?CommandDTO $command): void
    {
        $this->command = $command;
    }

    /**
     * @return bool
     */
    public function isCommand(): bool
    {
        return isset($this->command);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @param array $entities
     */
    public function setEntities(array $entities): void
    {
        $this->entities = $entities;
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
     */
    public function setFrom(FromDTO $from): void
    {
        $this->from = $from;
    }

    /**
     * @return ChatDTO
     */
    public function getChat(): ChatDTO
    {
        return $this->chat;
    }

    /**
     * @param ChatDTO $chat
     */
    public function setChat(ChatDTO $chat): void
    {
        $this->chat = $chat;
    }
}
