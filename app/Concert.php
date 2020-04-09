<?php

namespace App;

use App\Order;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];

    public function getTicketPriceInDollars(): string
    {
        return number_format($this->ticket_price / 100, 2);
    }

    public function getFormattedDate(): string
    {
        return $this->date->format('F j, Y');
    }

    public function getFormattedStartTime(): string
    {
        return $this->date->format('g:ia');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderTickets(string $email, int $ticketQuantity): Order
    {
        $order = $this->orders()->create(['email' => $email]);

        foreach(range(1, $ticketQuantity) as $i) {
            $order->tickets()->create([]);
        }

        return $order;
    }
}
