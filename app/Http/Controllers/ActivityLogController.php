<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use DateTime;

class ActivityLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:historizacija');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $logs = ActivityLog::take(50)->where('user_id', Crypt::decryptString(Session::get('ID')))->orderBy('created_at', 'DESC')->get();

        foreach ($logs as $log) {
            $log->created_at = Carbon::parse(date_format($log['created_at'], 'd.m.Y H:i:s'));
        }
        return view('/ostalo/historizacija/home', compact('logs'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($user_id, $function, $tableName, $oldData, $newData)
    {
        DB::table('activity_logs')->insert(
            ['created_at' => Carbon::now(), 'user_id' => $user_id, 'operation' => $function, 'tabela' => $tableName, 'old_data' => $oldData, 'new_data' => $newData]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $log = ActivityLog::findOrFail($id);

        $olddata = json_decode($log->old_data);
        $newdata = json_decode($log->new_data);
        $log->old_data = HelpController::format_table_columns($olddata);
        $log->new_data = HelpController::format_table_columns($newdata);

        foreach ($log->old_data as $key => $value) {
            $decoded = json_decode($value, true);

            if (is_null($decoded) || json_last_error() !== JSON_ERROR_NONE) {
            } else {
                if (gettype($decoded) === 'array') {
                    $log->old_data->$key = HelpController::format_table_columns($decoded);
                }
            }
        }

        foreach ($log->new_data as $key => $value) {
            $decoded = json_decode($value, true);

            if (is_null($decoded) || json_last_error() !== JSON_ERROR_NONE) {
            } else {
                if (gettype($decoded) === 'array') {
                    $log->new_data->$key = HelpController::format_table_columns($decoded);
                }
            }
        }

        return view('/ostalo/historizacija/detalji', compact('log'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
