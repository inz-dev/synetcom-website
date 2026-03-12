<?php

namespace App\Http\Controllers;

use App\Models\Departements;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DepartementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $data=Departements::with('Services')->get();

        //  dd('test:',  $data);
        return Inertia::render('Departements/Index.departements', [
            'allDepartments' => $data,

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
        try {

        $request->validate([

            'nom_departement' => 'required|string|min:4',
        ], [
            'nom_departement.required' => 'Veuillez entrer le nom du département.',
            'nom_departement.min' => 'Veuillez entrer un minimum de 4 caractères.',

        ]);
        $dept = Departements::create(
            ['nom_departement' => $request->nom_departement,

            ]

        );
        $dept->save();
        /* dd("save:", $dept); */
        } catch (\Throwable $th) {
            //throw $th;
            /* dump('th:',$th);
            dd('end throw'); */
          return Inertia::render('Departements/Index.departements', [
            'serverError' => $th->getMessage(), // ou un message custom
        ]);

        }

    }
    /**
     * Display the specified resource.
     */
    public function show(Departements $departements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departements $departements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departements $departements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departements $departements)
    {
        //
    }
}
