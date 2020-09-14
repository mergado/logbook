<?php

namespace App\Http\Controllers;

use App\MergadoModels\EshopModel;
use App\Models\Log;

class EshopController extends Controller
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
            'logoLink' => action('EshopController@index', ['eshop_id' => $eshopId]),
            'eshop' => $eshop,
        ]);
    }

}
