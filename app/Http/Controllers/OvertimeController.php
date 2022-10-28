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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $new_data = [];        
        $data = Employee::with(['overtimes' => function($q) {
        }])->get();
        $selected_setting = Setting::first();
        $formula = Reference::find($selected_setting->value);

        for($i=0;$i<count($data);$i++){
            $overtime_duration_total = 0;
            array_push($new_data, $data[$i]);
            if($new_data[$i]['overtimes'] != null && count($new_data[$i]['overtimes']) > 0){
                $overtime = $new_data[$i]['overtimes'];
                for($j=0;$j<count($overtime);$j++){
                    $first  = new DateTime($overtime[$j]['time_started']);
                    $second = new DateTime($overtime[$j]['time_ended']);
                    $overtime_duration =  $first->diff( $second );
                    $new_data[$i]['overtimes'][$j]['overtime_duration'] = (int) $overtime_duration->format( '%h' );
                    $overtime_duration_total += ((int) $overtime_duration->format( '%h' ));
                }
            }
            $new_data[$i]['overtime_duration_total'] = $overtime_duration_total;
            $amount = str_replace('salary', $data[$i]['salary'], (str_replace('overtime_duration_total', $overtime_duration_total, $formula->expression)));
            $new_data[$i]['amount'] = round(eval('return '.$amount.';'));
        }

        return $new_data;
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
     * Display the specified resource.
     *
     * @param  \App\Models\overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show(overtime $overtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(overtime $overtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, overtime $overtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(overtime $overtime)
    {
        //
    }
}
