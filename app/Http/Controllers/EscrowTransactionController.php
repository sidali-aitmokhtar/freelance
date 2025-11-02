<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEscrowTransactionRequest;
use App\Http\Requests\UpdateEscrowTransactionRequest;
use App\Models\EscrowTransaction;

class EscrowTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreEscrowTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EscrowTransaction $escrowTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EscrowTransaction $escrowTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEscrowTransactionRequest $request, EscrowTransaction $escrowTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EscrowTransaction $escrowTransaction)
    {
        //
    }
}
