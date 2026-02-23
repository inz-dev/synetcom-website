<?php

namespace App\Http\Controllers;

use App\Models\Departements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DepartementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Departements/Index.departements',[
            'allDepartments'=>Departements::all(),

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
        try {
            //code...
        $request->validate([
            'nom_departement'=>'required|string'
        ]);
        $dept = Departements::create($request->validate());
/*         dump('dept:', $dept);
dd("end try"); */
        $dept->save();
            return Redirect::route('departements')->with('OK', 'Opération réussie: ');

        } catch (\Throwable $th) {
            //throw $th;
           /*  dump('error:', $th);
            dd("end catch"); */
            return  Redirect::route('departements')->with('Erreur', 'Opération echouée: ' . $th->getMessage());
        }
        #dd("end");
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
