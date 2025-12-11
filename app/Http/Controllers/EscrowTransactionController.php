<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use App\Models\EscrowTransaction;
use App\Services\EscrowTransactionService;
use App\Http\Requests\EscrowTransactionRequest;

class EscrowTransactionController extends Controller
{
    public function __construct(
        private readonly EscrowTransactionService $escrowtransactionService
    ){}
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
    public function store(EscrowTransactionRequest $request)
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
    public function update(EscrowTransactionRequest $request, EscrowTransaction $escrowTransaction)
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
