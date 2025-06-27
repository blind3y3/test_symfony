<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 32)]
    private ?string $status = null;

    #[ORM\Column(length: 128)]
    private ?string $delivery_method = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order', orphanRemoval: true)]
    private Collection $orderItems;

    /**
     * @var Collection<int, OrderStatusHistory>
     */
    #[ORM\OneToMany(targetEntity: OrderStatusHistory::class, mappedBy: 'order')]
    private Collection $orderStatusHistory;

    /** Способ доставки - курьер */
    final public const DELIVERY_METHOD_COURIER = 'courier';

    /** Способ доставки - самовывоз */
    final public const DELIVERY_METHOD_PICKUP = 'pickup';

    /** Статус заказа - "Оплачен" */
    final public const STATUS_PAID = 'paid';

    /** Статус заказа - "Ждет сборки" */
    final public const STATUS_AWAITING_ASSEMBLY = 'awaiting_assembly';

    /** Статус заказа - "В сборке" */
    final public const STATUS_IN_ASSEMBLY = 'in_assembly';

    /** Статус заказа - "Готов к выдаче" */
    final public const STATUS_READY_FOR_DELIVERY = 'ready_for_delivery';

    /** Статус заказа - "Доставляется" */
    final public const STATUS_DELIVERY_IN_PROGRESS = 'delivery_in_progress';

    /** Статус заказа - "Получен" */
    final public const STATUS_RECEIVED = 'received';

    /** Статус заказа - "Отменен" */
    final public const STATUS_CANCELLED = 'cancelled';

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->orderStatusHistory = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getDeliveryMethod(): ?string
    {
        return $this->delivery_method;
    }

    public function setDeliveryMethod(string $delivery_method): static
    {
        $this->delivery_method = $delivery_method;

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

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderStatusHistory>
     */
    public function getOrderStatusHistory(): Collection
    {
        return $this->orderStatusHistory;
    }

    public function addOrderStatusHistory(OrderStatusHistory $orderStatusHistory): static
    {
        if (!$this->orderStatusHistory->contains($orderStatusHistory)) {
            $this->orderStatusHistory->add($orderStatusHistory);
            $orderStatusHistory->setOrder($this);
        }

        return $this;
    }

    public function removeOrderStatusHistory(OrderStatusHistory $orderStatusHistory): static
    {
        if ($this->orderStatusHistory->removeElement($orderStatusHistory)) {
            // set the owning side to null (unless already changed)
            if ($orderStatusHistory->getOrder() === $this) {
                $orderStatusHistory->setOrder(null);
            }
        }

        return $this;
    }
}
