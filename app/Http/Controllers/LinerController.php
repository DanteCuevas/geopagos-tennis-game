<?php

namespace App\Http\Controllers;

use App\Models\Liner;
use Illuminate\Http\Request;
use App\Exports\LinersExport;
use Maatwebsite\Excel\Facades\Excel;

class LinerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('liners.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function panel()
    {
        $liners = Liner::select('code_report', 'date_report')
            ->groupBy('code_report', 'date_report')
            ->orderBy('code_report', 'desc')
            ->get();
        return view('liners.panel', compact('liners'));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export($code)
    {
        return Excel::download(new LinersExport($code), $code.'.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liner  $liner
     * @return \Illuminate\Http\Response
     */
    public function show(Liner $liner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liner  $liner
     * @return \Illuminate\Http\Response
     */
    public function edit(Liner $liner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liner  $liner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liner $liner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liner  $liner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liner $liner)
    {
        //
    }
}
