<?php

namespace App\Http\Controllers;

class FirebaseController extends Controller
{
    /**
     * Authenticate
     *
     * @return response()
     */
    public function authenticate()
    {
        return view('firebase');
    }
}
