<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank]
    private ?string $phone = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Password cannot be blank.')]
    private ?string $password_hash = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $role = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, SmsLog>
     */
    #[ORM\OneToMany(targetEntity: SmsLog::class, mappedBy: 'user')]
    private Collection $smsLogs;

    public function __construct()
    {
        $this->smsLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPasswordHash(): ?string
    {
        return $this->password_hash;
    }

    public function setPasswordHash(string $password_hash): static
    {
        $this->password_hash = $password_hash;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password_hash;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials(): void
    {
        /*
         * Примечание: В Symfony 8 возможная логика будет вынесена в  __serialize()
         */
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return Collection<int, SmsLog>
     */
    public function getSmsLogs(): Collection
    {
        return $this->smsLogs;
    }

    public function addSmsLog(SmsLog $smsLog): static
    {
        if (!$this->smsLogs->contains($smsLog)) {
            $this->smsLogs->add($smsLog);
            $smsLog->setUser($this);
        }

        return $this;
    }

    public function removeSmsLog(SmsLog $smsLog): static
    {
        if ($this->smsLogs->removeElement($smsLog)) {
            // set the owning side to null (unless already changed)
            if ($smsLog->getUser() === $this) {
                $smsLog->setUser(null);
            }
        }

        return $this;
    }
}
