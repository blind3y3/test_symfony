<?php

namespace App\Entity;

use App\Repository\SmsLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SmsLogRepository::class)]
class SmsLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTime $sent_at = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'smsLogs')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getSentAt(): ?\DateTime
    {
        return $this->sent_at;
    }

    public function setSentAt(\DateTime $sent_at): static
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user->getId();
    }
}
