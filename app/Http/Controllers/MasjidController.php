<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Illuminate\Http\Request;

class MasjidController extends Controller
{
    public function autocomplete(Request $request)
    {
        $data = Masjid::select("nama_masjid as value", "id")
                    ->where('nama_masjid', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }

    public function show(Masjid $masjid)
    {
        return response()->json($masjid);
    }
}
