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
}
