<?php


namespace Tests\Browser;


use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewConcertListingTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserCanSeeConcertListing(): void
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
            'additional_information' => $additional_information = 'For tickets, call (228) 1488-1337'
        ]);

        $this->browse(function (Browser $browser) use($concert, $title, $subtitle, $date, $ticket_price,
            $venue, $venue_address, $city, $state, $zip, $additional_information) {
            $site = $browser->visit('/concerts/'.$concert->id);
            $site->assertSee($title);
            $site->assertSee($subtitle);
            $site->assertSee($date->format('F j, Y'));
            $site->assertSee($date->format('g:ia'));
            $site->assertSee(number_format($ticket_price / 100, 2));
            $site->assertSee($venue);
            $site->assertSee($venue_address);
            $site->assertSee($city);
            $site->assertSee($state);
            $site->assertSee($zip);
            $site->assertSee($additional_information);
        });
    }
}
