<?php

namespace Tests\Unit\Billing;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentFailedException;
use PHPUnit\Framework\TestCase;

class FakePaymentGatewayTest extends TestCase
{
    public function testChargesWithValidPaymentTokenAreSuccessful(): void
    {
        $paymentGateway = new FakePaymentGateway();

        $paymentGateway->charge($charge = 2500, $paymentGateway->getValidTestToken());

        $this->assertNotNull($charge, $paymentGateway->totalCharges());
    }

    public function testChargesWithInvalidPaymentTokenFail(): void
    {
        $paymentGateway = new FakePaymentGateway();

        $this->expectException(PaymentFailedException::class);

        $paymentGateway->charge($charge = 2500, 'invalid-payment-token');
    }
}
