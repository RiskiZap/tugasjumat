<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use App\Charts\MasjidLineChart;
use PDF;

class PetugasController extends Controller
{
    public function index()
    {   
        $title = "Data Petugas";
        $petugas = Petugas::orderBy('id','asc')->get();
        return view('petugass.index', compact(['petugas' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Petugas";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('petugass.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_petugas' => 'required'
        ]);

        $petugas = [
            'id_petugas' => $request->id_petugas,
            'nama_petugas' => $request->nama_petugas,
            'bulan' => $request->bulan,
        ];
        if($result = Petugas::create($petugas)){
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'id_petugas' => $request->id_petugas,
                    'id_masjid' => $request['id_masjid'.$i],
                    'bagian' => $request['bagian'.$i],
                    'keterangan' => $request['keterangan'.$i],
                ];
                Detail::create($details);
            }
        }
        return redirect()->route('petugass.index')->with('success','Petugas has been created successfully.');
    }

    public function show(Petugas $petugas)
    {
        return view('petugass.show', compact('petugas'));
    }

    public function edit(Petugas $petugas)
    {
        $title = "Edit Data Petugas";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        $detail = Detail::where('id_petugas', $petugas->id_petugas)->orderBy('id','asc')->get();
        return view('petugass.edit',compact('petugas' , 'title', 'managers'));
    }

    public function update(Request $request, Petugas $petugas)
    {
        $petugas->id_petugas = $request->id_petugas;
        $petugas->nama_petugas = $request->nama_petugas;
        $petugas->bulan = $request->bulan;
        // $petugas->total = $request->total;
    
        if ($petugas->save()) {
            Detail::where('id_petugas', $petugas->id_petugas)->delete();
            
            for ($i = 1; $i <= $request->jml; $i++) {
                $details = [
                    'id_petugas' => $petugas->id_petugas,
                    'id_masjid' => $request['id_masjid'.$i],
                    'bagian' => $request['bagian'.$i],
                ];
                Detail::create($details);
            }
        }
    
        return redirect()->route('petugass.index')->with('success', 'Departement Has Been updated successfully');
    }
    

    public function destroy(Petugas $petugas)
    {
        $petugas->delete();
        return redirect()->route('petugass.index')->with('success','Departement has been deleted successfully');
    }

    public function exportPdf()
    {
        $title = "Laporan Data Petugas";
        $petugass = Petugas::orderBy('id', 'asc')->get();

        $pdf = PDF::loadview('petugass.pdf', compact(['petugass', 'title']));
        return $pdf->stream('laporan-petugass-pdf');
    }

    public function chartLine()
    {
        $api = url(route('petugass.chartLineAjax'));

        $chart = new PetugasLineChart;
        $chart->labels(['Ibu dan Anak', 'THT', 'Jantung', 'Mata', 'Kandungan', 'Kulit', 'Penyakit Dalam'])->load($api);
        $title = "Chart Ajax";
        return view('chart', compact('chart', 'title'));
    }

    public function chartLineAjax(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');
        $petugas = Petugas::select(\DB::raw("COUNT(*) as count"))
            ->where('bulan', 'LIKE', '%' . $year . '%')
            ->groupBy(\DB::raw("bagian"))
            ->pluck('count');

        $chart = new PetugasLineChart;

        $chart->dataset('Petugas Spesialis Chart', 'bar', $petugas)->options([
            'backgroundColor' => '#51C1C0',
            'borderColor' => '#51C1C0',
            'fill' => 'true',
        ]);

        return $chart->api();
    }

}
