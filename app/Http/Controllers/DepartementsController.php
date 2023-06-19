<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departements;
use App\Models\User;
use PDF;

class DepartementSController extends Controller
{
    public function index()
    {
        $title = "Data Departement";
        $departements = Departements::orderBy('id', 'asc')->paginate();
        return view('departements.index', compact(['departements', 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Departement";
        $managers = User::where('position', '1')->get();
        return view('departements.create', compact(['managers', 'title']));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'location' => 'nullable',
            'manager_id' => 'required',
        ]);

        Departements::create($validatedData);

        return redirect()->route('departements.index')->with('success', 'Departement created successfully.');
    }


    public function show(Departements $departement)
    {
        return view('departements.show', compact('departement'));
    }


    public function edit(Departements $departement)
    {
        $title = "Edit Data Departement";
        $managers = User::where('position', '1')->get();
        return view('departements.edit', compact(['departement', 'managers', 'title']));
    }


    public function update(Request $request, Departements $departement)
    {
        $request->validate([
            'name' => 'required',
            'location',
            'manager_id'
        ]);

        $departement->fill($request->post())->save();

        return redirect()->route('departements.index')->with('success', 'Departement Has Been updated successfully');
    }


    public function destroy(Departements $departement)
    {
        $departement->delete();
        return redirect()->route('departements.index')->with('success', 'Departement has been deleted successfully');
    }

    public function exportPdf()
    {
        $title = "Laporan Data Departement";
        $departements = Departements::orderBy('id', 'asc')->get();

        $pdf = PDF::loadview('departements.pdf', compact(['departements', 'title']));
        return $pdf->stream('laporan-departements-pdf');
    }
}
