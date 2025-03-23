<?php

namespace App\Http\Controllers;

use App\Models\Waiter;
use App\Http\Requests\StoreWaiterRequest;
use App\Http\Requests\UpdateWaiterRequest;

class WaiterController extends Controller
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
     * @param  \App\Http\Requests\StoreWaiterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWaiterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function show(Waiter $waiter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiter $waiter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWaiterRequest  $request
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWaiterRequest $request, Waiter $waiter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiter $waiter)
    {
        //
    }
}
