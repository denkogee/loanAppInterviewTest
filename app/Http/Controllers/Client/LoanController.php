<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function create()
    {
        return view('client.loans.create');
    }

    public function store(LoanRequest $request, CreateLoan $createLoan)
    {
        // // Create loan record from user input and default parameters.
        // return ($createLoan->handle($request->validated()))
        //     ? redirect()->route('client.home')->with('success', 'Loan was successfully requested.')
        //     : back()->with('error', 'Sorry! An error occured while trying to request loan.');
    }

    public function edit(Loan $loan)
    {
        // return view('client.loans.edit', ['loan' => $loan]);
    }

    public function update(LoanRequest $request, UpdateLoan $updateLoan,  Loan $loan)
    {
        // // Update loan record from user input and default parameters.
        // return ($updateLoan->handle($loan, $request->validated()))
        //     ? redirect()->route('client.home')->with('success', 'Loan request was successfully updated.')
        //     : back()->with('error', 'Sorry! An error occured while trying to update loan request.');
    }

    public function destroy(Loan $loan)
    {
        /**
         * To soft delete a loan record use the `updateEntityAccess` method
         * e.g return $this->updateEntityAccess($loan['uuid'], '\App\Models\Loan');
         */

        // // Permanently delete loan record
        // return ($this->permanentlyDeleteEntity($loan['uuid'], '\App\Models\Loan'))
        //     ? redirect()->back()->with('success', 'Loan record was permanently deleted.')
        //     : back()->with('error', 'Sorry! An error occured while trying to permanently delete loan record.');
    }
}
