<?php

namespace App\Http\Controllers;

use App\Billing\PaymentFailedException;
use App\Billing\PaymentGateway;
use App\Concert;
use App\Http\Requests\ConcertOrderRequest;

class ConcertOrdersController extends Controller
{
    private PaymentGateway $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store(ConcertOrderRequest $request, $id)
    {
        try {
            $concert = Concert::published()->findOrFail($id);

            $ticketQuantity = $request->get('ticket_quantity');
            $amount = $ticketQuantity * $concert->ticket_price;
            $this->paymentGateway->charge($amount, $request->get('payment_token'));

            $order = $concert->orderTickets($request->get('email'), $request->get('ticket_quantity'));

            return response()->json([], 201);
        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        }
    }
}
