<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class SettingController extends Controller
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
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $validate = $request->validate([
                'key' => 'required|in:overtime_method',
                'value' => 'required|integer|exists:references,id',
            ]);
        } catch (Exception $e) {
            return ApiFormatter::createApi(400, 'Format data tidak sesuai');
        }

        $emp = Setting::first()->update($request->all());
        
        if ($emp) {
            return ApiFormatter::createApi(200, 'Success');
        } else {
            return ApiFormatter::createApi(400, 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(setting $setting)
    {
        //
    }
}
