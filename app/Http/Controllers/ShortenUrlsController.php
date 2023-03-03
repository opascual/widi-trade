<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShortenUrlsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return 'Shorten url functionality';
    }
}
