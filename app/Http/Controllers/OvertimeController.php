<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\ApiFormatter;
use App\Models\Employee;
use App\Models\Reference;
use App\Models\Setting;
use DateTime;
use Illuminate\Validation\Rule;





class OvertimeController extends Controller
{



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * * @OA\Post(
     *     path="/api/overtimes", 
     *     tags={"overtime"},
     *     summary="Membuat Data Overtime",
 
     *  @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *            @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="employee_id",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="date",
     *                          type="date"
     *                      ),
     *                      @OA\Property(
     *                          property="time_started",
     *                          type="time"
     *                      ),
     *                      @OA\Property(
     *                          property="time_ended",
     *                          type="time"
     *                      )
     *                 ),
     *                 example={
     *                     "employee_id":1,
     *                     "date":"2022-10-28",
     *                     "time_started":"06:00:00",
     *                     "time_ended":"10:45:00"
     *                }
     *             )           
     *         )
     *      ),
     * 
     *     @OA\Response(response="200", description="Success",
     * @OA\JsonContent(
     *              @OA\Property(property="employee_id", type="id", example="1"),
     *              @OA\Property(property="date", type="date", example=6500000),
     *              @OA\Property(property="time_started", type="time", example="Reynaldo"),
     *              @OA\Property(property="time_ended", type="time", example=8),
     *            
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
    public function store(Request $request)
    {
        //return $request;
        try {
            $validate = $request->validate([
                'employee_id' => 'required|numeric|exists:employees,id',
                'date' => [
                    'required',
                    'date_format:Y-m-d',
                    Rule::unique('overtimes')
                        ->where('employee_id', $request->input('employee_id'))
                        ->where('date', $request->input('date'))
                ],
                'time_started' => 'required|date_format:H:i:s|before:time_ended',
                'time_ended' => 'required|date_format:H:i:s|after:time_started',
            ]);
        } catch (Exception $e) {
            return ApiFormatter::createApi(400, 'Format data tidak sesuai');
        }

        $data = new overtime();
        $data->employee_id = $request->employee_id;
        $data->date = $request->date;
        $data->time_started = $request->time_started;
        $data->time_ended = $request->time_ended;
        $overtime = $data->save();

        if ($overtime) {
            return ApiFormatter::createApi(200, 'Success');
        } else {
            return ApiFormatter::createApi(400, 'Terjadi kesalahan');
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * * @OA\Get(
     *     path="/api/overtime-pays/calculate", 
     *     tags={"overtime_pay"},
     *     summary="Menampilkan Perhitungan Hasil Overtime",
     *      @OA\Parameter(
     *         name="month",
     *         in="query",
     *         description="Filter month",
     *         required=true,
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *      ),
     * 
     *     @OA\Response(response="200", description="Success",
     * @OA\JsonContent(
     *              @OA\Property(property="id", type="id", example="1"),
     *              @OA\Property(property="summary", type="integer", example=6500000),
     *              @OA\Property(property="name", type="string", example="Reynaldo"),
     *              @OA\Property(property="overtime_duration_total", type="integer", example=8),
     *              @OA\Property(property="amount", type="integer", example=80000),
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
    public function index(Request $request)
    {
        try {
            $validate = $request->validate([
                'month' => 'required|date_format:Y-m'
            ]);
        } catch (Exception $e) {
            return ApiFormatter::createApi(400, 'Format data tidak sesuai');
        }

        $new_data = [];
        $date = $request->month;
        $data = Employee::with(['overtimes' => function ($q) use ($date) {
            $newdate = explode("-", $date);
            $q->whereYear('date', $newdate[0])->whereMonth('date', $newdate[1]);
        }])->get();
        $selected_setting = Setting::first();
        $formula = Reference::find($selected_setting->value);

        for ($i = 0; $i < count($data); $i++) {
            $overtime_duration_total = 0;
            array_push($new_data, $data[$i]);
            if ($new_data[$i]['overtimes'] != null && count($new_data[$i]['overtimes']) > 0) {
                $overtime = $new_data[$i]['overtimes'];
                for ($j = 0; $j < count($overtime); $j++) {
                    $first  = new DateTime($overtime[$j]['time_started']);
                    $second = new DateTime($overtime[$j]['time_ended']);
                    $overtime_duration =  $first->diff($second);
                    $new_data[$i]['overtimes'][$j]['overtime_duration'] = (int) $overtime_duration->format('%h');
                    $overtime_duration_total += ((int) $overtime_duration->format('%h'));
                }
            }
            $new_data[$i]['overtime_duration_total'] = $overtime_duration_total;
            $amount = str_replace('salary', $data[$i]['salary'], (str_replace('overtime_duration_total', $overtime_duration_total, $formula->expression)));
            $new_data[$i]['amount'] = round(eval('return ' . $amount . ';'));
        }

        return $new_data;
    }
}
