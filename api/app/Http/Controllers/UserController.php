<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->resp($users);
    }

    public function user()
    {
        $user = JWTAuth::user();
        return $this->resp($user);
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
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $password = Hash::make($request->password);
        $company_id = $request->company_id;

        $check_account = User::where('email', $email)->orWhere('username', $username)->first();

        if($check_account){
            return $this->resp(null, 'Username Atau Email Sudah Ada', false, 406);
        }else{
            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'company_id' => $company_id
            ]);

            if(!$user){
                return $this->resp(null, 'Gagal Menambahkan Akun', false, 406);
            }else{
                return $this->resp($user);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find_user = User::find($id);

        $user = $find_user->with('companies')->get();

        if(!$find_user){
            return $this->resp(null, 'Data User Tidak Ada', false, 406);
        }else{
            return $this->resp($user);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->name;
        $username = $request->username;
        $check_user = User::find($id);

        $check_account = User::where('username', $username);

        if($check_account){
            return $this->resp(null, 'Username Sudah Ada', false, 400);
        }else{
            $check_user->update([
                'name' => $name,
                'username' => $username
            ]);
            return $this->resp($check_user);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_user = User::find($id);

        if(!$delete_user){
            return $this->resp(null, 'User Gagal Dihapus', false, 400);
        }else{
            $delete_user->delete();
            return $this->resp(null, 'User Berhasil Dihapus');
        }
    }
}
