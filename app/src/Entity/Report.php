<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $file_path = null;

    #[ORM\Column(type: 'uuid')]
    #[Groups('api-view')]
    private ?Uuid $badge = null;

    #[ORM\Column(length: 64)]
    #[Groups('api-view')]
    private ?string $status = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    public const STATUS_CREATED = 'created';
    public const STATUS_FINISHED = 'finished';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(?string $file_path): static
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function getBadge(): ?Uuid
    {
        return $this->badge;
    }

    public function setBadge(Uuid $badge): static
    {
        $this->badge = $badge;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
