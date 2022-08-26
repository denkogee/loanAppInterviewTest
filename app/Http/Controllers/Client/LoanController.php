<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $loans = Loan::where('user_id', auth()->id())
            ->orderBy("loans.id", "desc")
            ->get();
        return view('backend.client.loan.my_loans', compact('loans'));
    }

    public function create()
    {
        return view('backend.client.loan.create');
    }

    public function apply_loan(Request $request) {
        if ($request->isMethod('get')) {
            return view('backend.client.loan.apply_loan');
        } else if ($request->isMethod('post')) {
            @ini_set('max_execution_time', 0);
            @set_time_limit(0);

            $validator = Validator::make($request->all(), [
                'loan_product_id'    => 'required',
                'currency_id'        => 'required',
                'first_payment_date' => 'required',
                'applied_amount'     => 'required|numeric',
                'attachment'         => 'nullable|mimes:jpeg,png,jpg,doc,pdf,docx,zip',
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
                } else {
                    return redirect()->route('loans.apply_new')
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            $attachment = "";
            if ($request->hasfile('attachment')) {
                $file       = $request->file('attachment');
                $attachment = time() . $file->getClientOriginalName();
                $file->move(public_path() . "/uploads/media/", $attachment);
            }

            DB::beginTransaction();

            $loan                         = new Loan();
            $loan->loan_product_id        = $request->input('loan_product_id');
            $loan->borrower_id            = auth()->id();
            $loan->currency_id            = $request->input('currency_id');
            $loan->first_payment_date     = $request->input('first_payment_date');
            $loan->applied_amount         = $request->input('applied_amount');
            $loan->late_payment_penalties = 0;
            $loan->attachment             = $attachment;
            $loan->description            = $request->input('description');
            $loan->remarks                = $request->input('remarks');
            $loan->created_user_id        = auth()->id();

            $loan->save();

            // Create Loan Repayments
            $calculator = new Calculator(
                $loan->applied_amount,
                $request->first_payment_date,
                $loan->loan_product->interest_rate,
                $loan->loan_product->term,
                $loan->loan_product->term_period,
                $loan->late_payment_penalties
            );

            if ($loan->loan_product->interest_type == 'flat_rate') {
                $repayments = $calculator->get_flat_rate();
            } else if ($loan->loan_product->interest_type == 'fixed_rate') {
                $repayments = $calculator->get_fixed_rate();
            } else if ($loan->loan_product->interest_type == 'mortgage') {
                $repayments = $calculator->get_mortgage();
            } else if ($loan->loan_product->interest_type == 'one_time') {
                $repayments = $calculator->get_one_time();
            }

            $loan->total_payable = $calculator->payable_amount;
            $loan->save();

            DB::commit();

            if ($loan->id > 0) {
                return redirect()->route('loans.my_loans')->with('success', _lang('Your Loan application submitted sucessfully and your application is now under review'));
            }
        }

    }

    public function calculate(Request $request) {
        $validator = Validator::make($request->all(), [
            'apply_amount'           => 'required|numeric',
            'interest_rate'          => 'required',
            'interest_type'          => 'required',
            'term'                   => 'required|integer|max:100',
            'term_period'            => $request->interest_type == 'one_time' ? '' : 'required',
            'late_payment_penalties' => 'required',
            'first_payment_date'     => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('loans.admin_calculator')->withErrors($validator)->withInput();
            }
        }

        $first_payment_date     = $request->first_payment_date;
        $apply_amount           = $request->apply_amount;
        $interest_rate          = $request->interest_rate;
        $interest_type          = $request->interest_type;
        $term                   = $request->term;
        $term_period            = $request->term_period;
        $late_payment_penalties = $request->late_payment_penalties;

        $data       = array();
        $table_data = array();

        $data['table_data']             = $table_data;
        $data['first_payment_date']     = $request->first_payment_date;
        $data['apply_amount']           = $request->apply_amount;
        $data['interest_rate']          = $request->interest_rate;
        $data['term']                   = $request->term;
        $data['term_period']            = $request->term_period;
        $data['late_payment_penalties'] = $request->late_payment_penalties;

        return view('backend.loan.calculator', $data);

    }

    public function calculator(Request $request) {
        if ($request->isMethod('get')) {
            $data                           = array();
            $data['first_payment_date']     = '';
            $data['apply_amount']           = '';
            $data['interest_rate']          = '';
            $data['term']                   = '';
            $data['term_period']            = '';
            $data['late_payment_penalties'] = 0;
            return view('backend.client.loan.calculator', $data);
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'apply_amount'           => 'required|numeric',
                'interest_rate'          => 'required',
                'term'                   => 'required|integer|max:100',
                'term_period'            => $request->interest_type == 'one_time' ? '' : 'required',
                'late_payment_penalties' => 'required',
                'first_payment_date'     => 'required',
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
                } else {
                    return redirect()->route('loans.calculator')->withErrors($validator)->withInput();
                }
            }

            $first_payment_date     = $request->first_payment_date;
            $apply_amount           = $request->apply_amount;
            $interest_rate          = $request->interest_rate;
            $term                   = $request->term;
            $term_period            = $request->term_period;
            $late_payment_penalties = $request->late_payment_penalties;

            $data       = array();
            $table_data = array();

            $data['table_data']             = $table_data;
            $data['first_payment_date']     = $request->first_payment_date;
            $data['apply_amount']           = $request->apply_amount;
            $data['interest_rate']          = $request->interest_rate;
            $data['term']                   = $request->term;
            $data['term_period']            = $request->term_period;
            $data['late_payment_penalties'] = $request->late_payment_penalties;

            return view('backend.client.loan.calculator', $data);
        }
    }

    public function edit(Loan $loan)
    {
        
    }

    public function update(LoanRequest $request, UpdateLoan $updateLoan,  Loan $loan)
    {

    }

    public function destroy(Loan $loan)
    {

    }
}
