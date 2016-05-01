<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

use App\Http\Requests;

class WidgetController extends Controller
{
    /**
     * Renders eshop Widget
     * @param $eshopId
     * @return $this
     */
    public function eshopWidget($eshopId) {

        $logs = Log::where('eshop_id', $eshopId)
            ->join('users', 'logs.user_id', '=', 'users.id')
            ->orderBy('logs.date', 'desc')
            ->orderBy('logs.created_at', 'desc')
            ->select('logs.date','users.name', 'logs.body')
            ->take(3)->get();

        return view('project.widget')->with([
            'logs' => $logs,
            'eshopId' => $eshopId,
        ]);
    }

    /**
     * Renders project Widget
     * @param $eshopId
     * @param $projectId
     * @return $this
     */
    public function projectWidget($eshopId, $projectId) {

        $logs = Log::where('project_id', $projectId)
            ->join('users', 'logs.user_id', '=', 'users.id')
            ->orderBy('logs.date', 'desc')
            ->orderBy('logs.created_at', 'desc')
            ->select('logs.date','users.name', 'logs.body')
            ->take(3)->get();

        return view('project.widget')->with([
            'logs' => $logs,
            'eshopId' => $eshopId,
            'projectId' => $projectId
        ]);
    }


}
