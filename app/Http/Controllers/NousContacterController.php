<?php

namespace App\Http\Controllers;

use App\Models\NousContacter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NousContacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

           return Inertia::render('NousContacter/Index', [

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NousContacter $nousContacter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NousContacter $nousContacter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NousContacter $nousContacter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NousContacter $nousContacter)
    {
        //
    }
}
