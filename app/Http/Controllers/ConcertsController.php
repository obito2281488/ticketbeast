<?php

namespace App\Http\Controllers;

use App\Concert;
use Illuminate\Http\Request;

class ConcertsController extends Controller
{
    public function show(int $id)
    {
        $concert = Concert::where('id', $id)->firstOrFail();

        return view('concerts.show')->with('concert', $concert);
    }
}
