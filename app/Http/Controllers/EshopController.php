<?php

namespace App\Http\Controllers;

use App\MergadoModels\EshopModel;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class EshopLogsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eshopId)
    {
        $eshopModel = new EshopModel();
        $eshop = $eshopModel->query($eshopId)->fields(['id', 'name', 'permissions'])->get();
        $projects = $eshopModel->query($eshopId)->projects()->limit(30)->get()->data;

        usort($projects, function($a, $b) {
            return strcmp($a->name, $b->name);
        });

        foreach($projects as $project) {
            $project->logs = Log::where('project_id', $project->id)
                ->join('users', 'logs.user_id', '=', 'users.id')
                ->orderBy('logs.date', 'desc')
                ->select('logs.*','users.name')
                ->take(5)->get();
        }

        return view('eshop.projects.index')->with([
            'projects' => $projects,
            'logoLink' => action('EshopLogsController@index', ['eshop_id' => $eshopId]),
            'eshop' => $eshop,
        ]);
    }

}
