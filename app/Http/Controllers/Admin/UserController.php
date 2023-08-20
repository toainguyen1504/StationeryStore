<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        $data = DB::table('users')->orderBy('created_at', 'DESC')->get();
        // dd($data);   
        $account_admin = DB::table('users')->where('role', 0)->first();
        // dd($account_admin);  
        return view('admin.user.index', ['user' => $data], ['admin' => $account_admin]);
    }

    public function create()
    {
        $data = DB::table('categories')->orderBy('created_at', 'desc')->get();
        $accountAdmin = DB::table('users')->orderBy('created_at', 'desc')->where('role', 0)->first();
        return view('register', ['category' => $data], ['account' => $accountAdmin]);
    }

    public function edit($id)
    {
        $data = DB::table('users')->where('id', $id)->first();
        // dd($data);
        return view('admin.user.edit', ['user' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        // dd($data);
        $data['updated_at'] = new \DateTime();

        DB::table('users')->where('id', $id)->update($data);
        return redirect()->route('admin.user.index')->with('success', 'Update User successfully');
    }


    public function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('admin.user.index');
    }
}
