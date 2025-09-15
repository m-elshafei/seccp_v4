<?php

namespace App\DataObjects;


class NotificationData
{
    private string $title;
    private string $message;
    private ?string $link;
    private string $backgroundClass;
    private string $iconClass;

    public function __construct(
        string $title,
        string $message,
        ?string $link = null,
        string $backgroundClass = 'bg-light-success',
        string $iconClass = 'check'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
        $this->backgroundClass = $backgroundClass;
        $this->iconClass = $iconClass;
    }

    public function getTitle(): string { return $this->title; }
    public function getMessage(): string { return $this->message; }
    public function getLink(): ?string { return $this->link; }
    public function getBackgroundClass(): string { return $this->backgroundClass; }
    public function getIconClass(): string { return $this->iconClass; }
}
