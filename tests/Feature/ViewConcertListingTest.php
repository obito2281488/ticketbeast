<?php

namespace Tests\Feature;

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewConcertListingTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanSeePublishedConcertListing(): void
    {

        $concert = Concert::create([
            'title' => $title = 'The Red Chord',
            'subtitle' => $subtitle = 'with Animosity and Lethargy',
            'date' => $date = Carbon::parse('December 13, 2021 8:00pm'),
            'ticket_price' => $ticket_price = 3250,
            'venue' => $venue = 'The Mosh Pit',
            'venue_address' => $venue_address = '123 Example Lane',
            'city' => $city = 'Laraville',
            'state' => $state = 'ON',
            'zip' => $zip = '1488',
            'published_at' => Carbon::parse('-1 week'),
            'additional_information' => $additional_information = 'For tickets, call (228) 1488-1337'
        ]);

        $response = $this->get('/concerts/'.$concert->id);
        $response->assertSee($title);
        $response->assertSee($subtitle);
        $response->assertSee($date->format('F j, Y'));
        $response->assertSee($date->format('g:ia'));
        $response->assertSee(number_format($ticket_price / 100, 2));
        $response->assertSee($venue);
        $response->assertSee($venue_address);
        $response->assertSee($city);
        $response->assertSee($state);
        $response->assertSee($zip);
        $response->assertSee($additional_information);
    }

    public function testUserCannotViewUnpublishedConcertListing(): void
    {
        $concert = factory(Concert::class)->create([
            'published_at' => null
        ]);

        $response = $this->get('/concerts/'.$concert->id);
        $response->assertStatus(404);

    }
}
