<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("/docs/index.html");
});

Route::get('/passengers', function () {
    $passengers = \App\Passenger::where("name", "like", request("query") . "%")
        ->get();

    return $passengers->map(function ($passenger) {
        return $passenger->toArray() + ["num" => $passenger->id];
    })->all();
});

Route::get('/spaceships/serial_numbers/{typeId}', function ($typeId) {
    $type = \App\SpaceshipType::findOrFail($typeId);

    return [
        "data" => collect(range($type->id*100, ($type->id*100)+99))
            ->map(function ($number) {
                return [
                    "id" => $number,
                    "serial" => str_pad($number, 5, "0", STR_PAD_LEFT)
                ];
            })
            ->filter(function ($number) {
                return \Illuminate\Support\Str::contains($number["serial"], request('query'));
            })
            ->values()
    ];
});
