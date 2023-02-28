<?php

namespace App\Http\Controllers\API\v1;

use Exception;
use App\Models\User;
use App\Models\Santri;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $santris = Santri::all();

        if ($santris) {
            return ApiFormatter::createApi(200, 'Success', $santris);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'nis' => 'required|string|unique:santris,nis'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();
        if ($user) {

            $santri = Santri::create([
                'nis' => $fields['nis'],
                'user_id' => $user->id
            ]);

            $data = Santri::where('nis', '=', $santri->nis)->get();
            if ($data) {
                return ApiFormatter::createApi(201, 'Success', $data);
            } else {
                return ApiFormatter::createApi(500, 'Failed');
            }
        } else {
            return ApiFormatter::createApi(400, 'Failed yours credentials account!');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nis)
    {
        $santri = Santri::where('nis', '=', $nis)->get();

        if ($santri) {
            return ApiFormatter::createApi(200, 'Success', $santri);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
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
    public function update(Request $request, $nis)
    {
        try {
            $request->validate([
                'nis' => 'required|string',
                'user_id' => 'required|integer',
                'program' => 'string',
                'fullname' => 'string',
                'dob' => 'string',
                'pob' => 'string',
                'username' => 'string',
                'username' => 'string',
                'username' => 'string',
                'username' => 'string',
                'username' => 'string',
                'username' => 'string',
                'username' => 'string',
                'username' => 'string',
            ]);


            $santri = Santri::where('nis', '=', $nis)->get();

            $santri->update([
                'username' => (isset($request->username)) ? $request->username : $santri->username,
                'email' => (isset($request->email)) ? $request->email : $santri->email
            ]);

            $data = User::where('id', '=', $santri->id)->get();

            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nis)
    {
        try {
            $santri = Santri::where('id', '=', $nis)->get();
            $user = User::where('id', '=', $santri->user_id)->get();

            $santri->delete();
            $data = $user->delete();

            if ($data) {
                return ApiFormatter::createApi(200, 'Success Destory data');
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }
}