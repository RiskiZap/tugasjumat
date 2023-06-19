<?php

namespace App\Http\Controllers;
use App\Models\Positions;
use Illuminate\Http\Request;
use App\Exports\ExportPositions;
use Maatwebsite\Excel\Facades\Excel;

class PositionsController extends Controller
{
    public function index()
    {
        $title = "Data Position";
        $positions = Positions::orderBy('id', 'asc')->paginate();
        return view('positions.index', compact(['positions', 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Position";
        return view('positions.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'keterangan',
            'alias',
        ]);

        Positions::create($request->post());

        return redirect()->route('positions.index')->with('success', 'Position has been created successfully.');
    }


    public function show(Positions $position)
    {
        return view('positions.show', compact('position'));
    }


    public function edit(Positions $position)
    {
        $title = "Edit Data Position";
        return view('positions.edit', compact(['position', 'title']));
    }

    public function update(Request $request, Positions $position)
    {
        $request->validate([
            'name' => 'required',
            'keterangan',
            'alias',
        ]);

        $position->fill($request->post())->save();

        return redirect()->route('positions.index')->with('success', 'Position Has Been updated successfully');
    }


    public function destroy(Positions $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Position has been deleted successfully');
    }

    public function exportExcel(){
        return Excel::download(new ExportPositions, 'positions.xlsx');
    }
}