<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $myVar = rand(5, 10);

        return view('welcome', compact('myVar')) // compact passa le variabili passate con i nomi di stringa
        ->with('var_name', 5) // passa una variabile con nome primo argomento e valore secondo argomento
        ->withAnotherVariable('x') // il nome della variabile è contenuto nel nome della funzione
        ->with([
            'var1' => 'aaa',
            'var2' => 'bbb',
        ]); // passare più variabili
    }
}
