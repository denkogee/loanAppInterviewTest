<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.user.list', compact('status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$request->ajax()) {
            return view('backend.user.create');
        } else {
            return view('backend.user.modal.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|max:255',
            'email'           => 'required|email|unique:users|max:255',
            'account_number'  => 'required|max:30|unique:users',
            'branch_id'       => 'required',
            'status'          => 'required',
            'profile_picture' => 'nullable|image',
            'password'        => 'required|min:6',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('users.create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $profile_picture = "";
        if ($request->hasfile('profile_picture')) {
            $file            = $request->file('profile_picture');
            $profile_picture = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/profile/", $profile_picture);
        }

        $user                    = new User();
        $user->name              = $request->input('name');
        $user->email             = $request->input('email');
        $user->country_code      = $request->input('country_code');
        $user->phone             = $request->input('phone');
        $user->account_number    = $request->input('account_number');
        $user->user_type         = 'customer';
        $user->branch_id         = $request->branch_id;
        $user->status            = $request->input('status');
        $user->profile_picture   = $profile_picture;
        $user->email_verified_at = $request->email_verified_at;
        $user->sms_verified_at   = $request->sms_verified_at;
        $user->password          = Hash::make($request->password);

        $user->save();

        //Increment Account Number
        increment_account_number();

        //Prefix Output
        $user->status          = status($user->status);
        $user->branch_id       = $user->branch->name;
        $user->profile_picture = '<img src="' . profile_picture($user->profile_picture) . '" class="thumb-sm img-thumbnail">';

        if (!$request->ajax()) {
            return redirect()->route('users.create')->with('success', _lang('Saved successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Saved successfully'), 'data' => $user, 'table' => '#users_table']);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $user            = User::find($id);
        $account_balance = DB::select("SELECT currency.*, (SELECT IFNULL(SUM(amount), 0) FROM transactions
            WHERE dr_cr = 'cr' AND currency_id = currency.id AND status != 0 AND transactions.user_id = " . $user->id . ") - (SELECT IFNULL(SUM(amount),0)
            FROM transactions WHERE dr_cr = 'dr' AND currency_id = currency.id AND status != 0 AND transactions.user_id = " . $user->id . ") as balance
            FROM currency LEFT JOIN transactions ON currency.id=transactions.currency_id WHERE currency.status=1 GROUP BY currency.id");
        if (!$request->ajax()) {
            return view('backend.user.view', compact('user', 'id', 'account_balance'));
        } else {
            return view('backend.user.modal.view', compact('user', 'id', 'account_balance'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $user = User::find($id);
        if (!$request->ajax()) {
            return view('backend.user.edit', compact('user', 'id'));
        } else {
            return view('backend.user.modal.edit', compact('user', 'id'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|max:255',
            'email'            => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'account_number'   => [
                'required',
                'max:30',
                Rule::unique('users')->ignore($id),
            ],
            'status'           => 'required',
            'profile_picture'  => 'nullable|image',
            'password'         => 'nullable|min:6',
            'allow_withdrawal' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('users.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if ($request->hasfile('profile_picture')) {
            $file            = $request->file('profile_picture');
            $profile_picture = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/profile/", $profile_picture);
        }

        $user                   = User::find($id);
        $user->name             = $request->input('name');
        $user->email            = $request->input('email');
        $user->country_code     = $request->input('country_code');
        $user->phone            = $request->input('phone');
        $user->account_number   = $request->input('account_number');
        $user->status           = $request->input('status');
        $user->branch_id        = $request->branch_id;
        $user->allow_withdrawal = $request->allow_withdrawal;
        if ($request->hasfile('profile_picture')) {
            $user->profile_picture = $profile_picture;
        }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->email_verified_at = $request->email_verified_at;
        $user->sms_verified_at   = $request->sms_verified_at;

        $user->save();

        //Prefix Output
        $user->status          = status($user->status);
        $user->branch_id       = $user->branch->name;
        $user->profile_picture = '<img src="' . profile_picture($user->profile_picture) . '" class="thumb-sm img-thumbnail">';

        if (!$request->ajax()) {
            return redirect()->route('users.index')->with('success', _lang('Updated successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Updated successfully'), 'data' => $user, 'table' => '#users_table']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', _lang('Deleted successfully'));
    }
}
