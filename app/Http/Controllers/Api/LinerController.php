<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Liner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'data' => Liner::all()
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $orden = Liner::count(); $orden = $orden/30;
        $report = 'REPORT-'.now()->toDateTimeString();
        $report = str_replace(' ', '_', $report);
        $date = now();
        foreach ($data as $key => $seat) {
            $col = 1; $row = ($key + 1);
            if ($key >= 10){
                $col = 2; $row = ($key + 1 - 10);
            }
            if ($key >= 20){
                $col = 3; $row = ($key + 1 - 20);
            }
            $loc = 'F'.$col.'C'.$row;
            $seatData = [
                'code_report' => $report,
                'code' => 'LINER'.$key,
                'date_report' => $date,
                'status' => $seat['status'],
                'location' => $loc,
                'orden' => $orden
            ];

            Liner::create($seatData);
        }
        return response()->json([]);
    }

}
