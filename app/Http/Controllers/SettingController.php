<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class SettingController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\setting
     * @return \Illuminate\Http\Response
     * 
     * @OA\PATCH(
     *     path="/api/settings", 
     *     tags={"setting"},
     *     summary="Mengubah data setting",
     *  @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="key",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="value",
     *                          type="integer"
     *                      )
     *                 ),
     *                 example={
     *                     "key":"overtime_method",
     *                     "value": 1
     *                }
     *             )
     *         )
     *      ),
     * 
     *     @OA\Response(response="200", description="Success",
     * @OA\JsonContent(
     *              @OA\Property(property="key", type="string", example="overtime_method"),
     *              @OA\Property(property="value", type="integer", example=1),
     * )
     * ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Terjadi kesalahan"),
     *          )
     *      )
     * )
     * 
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
}
