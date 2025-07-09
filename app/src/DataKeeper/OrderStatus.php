<?php

declare(strict_types=1);

namespace App\DataKeeper;

enum OrderStatus: string
{
    /** Статус заказа - "Оплачен" */
    case PAID = 'paid';

    /** Статус заказа - "Ждет сборки" */
    case AWAITING_ASSEMBLY = 'awaiting_assembly';

    /** Статус заказа - "В сборке" */
    case IN_ASSEMBLY = 'in_assembly';

    /** Статус заказа - "Готов к выдаче" */
    case READY_FOR_DELIVERY = 'ready_for_delivery';

    /** Статус заказа - "Доставляется" */
    case DELIVERY_IN_PROGRESS = 'delivery_in_progress';

    /** Статус заказа - "Получен" */
    case RECEIVED = 'received';

    /** Статус заказа - "Отменен" */
    case CANCELLED = 'cancelled';

    public static function getLabels(): array
    {
        return [
            self::prepareName(self::PAID->name)                 => self::PAID->value,
            self::prepareName(self::AWAITING_ASSEMBLY->name)    => self::AWAITING_ASSEMBLY->value,
            self::prepareName(self::IN_ASSEMBLY->name)          => self::IN_ASSEMBLY->value,
            self::prepareName(self::READY_FOR_DELIVERY->name)   => self::READY_FOR_DELIVERY->value,
            self::prepareName(self::DELIVERY_IN_PROGRESS->name) => self::DELIVERY_IN_PROGRESS->value,
            self::prepareName(self::RECEIVED->name)             => self::RECEIVED->value,
            self::prepareName(self::CANCELLED->name)            => self::CANCELLED->value,
        ];
    }

    private static function prepareName(string $name): string
    {
        return str_replace('_', ' ', ucfirst(mb_strtolower($name)));
    }
}
