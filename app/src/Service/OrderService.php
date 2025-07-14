<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Exception\CartWrongItemsCountException;
use App\Exception\PickedProductException;
use App\Factory\OrderFactory;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

readonly class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private OrderFactory $orderFactory,
        private EntityManagerInterface $entityManager,
        private OrderStatusHistoryService $orderStatusHistoryService,
    ) {
    }

    /** @return Order[] */
    public function getListByUser(User $user, ?string $status = null, int $limit = 20): array
    {
        return $this->orderRepository->findBy(['user' => $user, 'status' => [$status]], ['id' => 'DESC'], $limit);
    }

    /**
     * @throws CartWrongItemsCountException
     * @throws Exception
     */
    public function create(User $user, string $deliveryMethod): Order
    {
        if ($user->getCartItems()->count() < 1 || $user->getCartItems()->count() > 20) {
            throw new CartWrongItemsCountException();
        }

        /** @var Order $order */
        $order = $this->entityManager->wrapInTransaction(function (EntityManagerInterface $em) use (
            $user,
            $deliveryMethod
        ) {
            $order = $this->orderFactory->createPaidByUser($user);
            $order->setDeliveryMethod($deliveryMethod);
            $this->orderRepository->save($order);
            $this->orderStatusHistoryService->updateOrderStatus($order);

            foreach ($user->getCartItems() as $cartItem) {
                if (!$cartItem->getProduct()->isActive()) {
                    continue;
                }

                $orderItem = new OrderItem();

                $orderItem->setOrder($order)
                    ->setProduct($cartItem->getProduct())
                    ->setPrice($cartItem->getProduct()->getPrice())
                    ->setQuantity($cartItem->getQuantity());

                $order->addOrderItem($orderItem);

                $em->persist($orderItem);
                $em->remove($cartItem);
            }

            if (0 === $order->getOrderItems()->count()) {
                throw new PickedProductException();
            }

            $em->flush();

            return $order;
        });

        return $order;
    }
}
