<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultiStepFormRequest;
use Inertia\Inertia;
use App\Models\City;
use Inertia\Response;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;

class MultiStepController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'countries' => Country::all()->toArray(),
            'cities' => City::all()->groupBy('country_id')->toArray(),
        ]);
    }

    public function store(MultiStepFormRequest $request): RedirectResponse
    {
        $cityPrice = City::find($request->integer('step2.to_city'));
        $price = $cityPrice->adult_price + ($cityPrice->children_price * $request->integer('step3.children'));

        return redirect()->route('success')->with('price', $price);
    }
}
