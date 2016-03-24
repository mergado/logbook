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

    private $user;

    public function __construct()
    {

        $session = Session::get('oauth');

        $this->user = User::find(Session::get('oauth')->getResourceOwnerId())->id;

    }

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

        foreach($projects as $project) {
            $project->logs = Log::where('project_id', $project->id)
                ->join('users', 'logs.user_id', '=', 'users.id')
                ->orderBy('logs.date', 'desc')
                ->select('logs.*','users.name')
                ->take(5)->get();
        }

        return view('eshop.projects.index')->with([
            'user' => $this->user,
            'projects' => $projects,
            'logoLink' => action('EshopLogsController@index', ['eshop_id' => $eshopId]),
            'eshop' => $eshop,
        ]);
    }

    public function widget($eshopId) {

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

}
