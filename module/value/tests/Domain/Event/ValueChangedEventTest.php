<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Value\Tests\Domain\Event;

use Ergonode\Attribute\Domain\ValueObject\AttributeCode;
use Ergonode\SharedKernel\Domain\AggregateId;
use Ergonode\Value\Domain\Event\ValueChangedEvent;
use Ergonode\Value\Domain\ValueObject\ValueInterface;
use PHPUnit\Framework\TestCase;

class ValueChangedEventTest extends TestCase
{
    public function testEventCreation(): void
    {
        /** @var AggregateId $id */
        $id = $this->createMock(AggregateId::class);
        /** @var AttributeCode $code */
        $code = $this->createMock(AttributeCode::class);
        /** @var ValueInterface $to */
        $to = $this->createMock(ValueInterface::class);

        $event = new ValueChangedEvent($id, $code, $to);
        $this->assertSame($id, $event->getAggregateId());
        $this->assertSame($code, $event->getAttributeCode());
        $this->assertSame($to, $event->getTo());
    }
}
