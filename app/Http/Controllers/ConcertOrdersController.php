<?php

namespace App\Http\Controllers;

use App\Billing\PaymentFailedException;
use App\Billing\PaymentGateway;
use App\Concert;
use App\Exceptions\NotEnoughTicketsException;
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

            $order = $concert->orderTickets($request->get('email'), $request->get('ticket_quantity'));
            $this->paymentGateway->charge($amount, $request->get('payment_token'));

            return response()->json([
                'email' => $request->get('email'),
                'ticket_quantity' => $ticketQuantity,
                'amount' => $amount
            ], 201);

        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response()->json([], 422);
        }
    }
}
