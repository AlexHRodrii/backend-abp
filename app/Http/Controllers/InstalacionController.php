<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Http\Requests\StoreInstalacionRequest;
use App\Http\Requests\UpdateInstalacionRequest;

class InstalacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreInstalacionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstalacionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instalacion  $instalacion
     * @return \Illuminate\Http\Response
     */
    public function show(Instalacion $instalacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instalacion  $instalacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Instalacion $instalacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstalacionRequest  $request
     * @param  \App\Models\Instalacion  $instalacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstalacionRequest $request, Instalacion $instalacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instalacion  $instalacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instalacion $instalacion)
    {
        //
    }
}
