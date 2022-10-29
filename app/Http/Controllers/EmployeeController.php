<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Dotenv\Validator;
use App\Helpers\ApiFormatter;
use Exception;
use Illuminate\Http\Request;

/**

 * @OA\Post(
 *     path="/api/employees", 
 *     tags={"employees"},
 *     summary="Membuat Data Employee",
 
 *  @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                      type="object",
 *                      @OA\Property(
 *                          property="name",
 *                          type="string"
 *                      ),
 *                      @OA\Property(
 *                          property="salary",
 *                          type="integer"
 *                      )
 *                 ),
 *                 example={
 *                     "name":"Reynaldo",
 *                     "salary":6500000
 *                }
 *             )
 *         )
 *      ),
 * 
 *     @OA\Response(response="200", description="Success",
 * @OA\JsonContent(
 *              @OA\Property(property="name", type="string", example="Reynaldo"),
 *              @OA\Property(property="summary", type="integer", example=6500000),
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
 */

class EmployeeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|alpha|min:2|',
                'salary' => 'required|integer|min:2000000|max:10000000',
            ]);
        } catch (Exception $e) {
            return ApiFormatter::createApi(400, 'Format data tidak sesuai');
        }

        $data = new employee();
        $data->name = $request->name;
        $data->salary = $request->salary;
        $emp = $data->save();

        if ($emp) {
            return ApiFormatter::createApi(200, 'Success');
        } else {
            return ApiFormatter::createApi(400, 'Terjadi kesalahan');
        }
    }
}


