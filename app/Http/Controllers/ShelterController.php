<?php

namespace App\Http\Controllers;

use App\Models\Shelter;
use Illuminate\View\View;


class ShelterController extends Controller
{
    public function show(Shelter $shelter): View
    {
        $animals = $shelter->animals()
            ->whereNull('adopted_at')
            ->get();

        return view('shelters.show', compact('shelter', 'animals'));
    }
}
