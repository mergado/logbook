<?php

namespace App\Http\Controllers;

use App\MergadoModels\ProjectModel;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProjectLogsController extends Controller
{

    private $user;

    public function __construct()
    {

        $this->user = User::find(Session::get('oauth')->getResourceOwnerId())->id;

    }

    /**
     * Display a listing of the resource.
     *
     * @param $projectId
     * @return \Illuminate\Http\Response
     */
    public function index($eshopId, $projectId)
    {

        $projectModel = new ProjectModel();
        $project = $projectModel->get($projectId);

        $logs = Log::where('project_id', $projectId)
            ->join('users', 'logs.user_id', '=', 'users.id')
            ->orderBy('logs.date', 'desc')
            ->orderBy('logs.created_at', 'desc')
            ->select('logs.*','users.name')
            ->paginate(15);

        return view('project.logs.index')->with([
            'logs' => $logs,
            'user' => $this->user,
            'project' => $project,
            'logoLink' => action('ProjectLogsController@index', ['eshop_id' => $eshopId, 'projectId' => $projectId]),
            'eshopId' => $eshopId,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($eshopId, $projectId)
    {

        $projectModel = new ProjectModel();
        $project = $projectModel->get($projectId);

        return view('project.logs.create')->with([
            'project' => $project,
            'logoLink' => action('ProjectLogsController@index', ['eshop_id' => $eshopId, 'projectId' => $projectId]),
            'eshopId' => $eshopId,
            'fromEshop' => Input::get('eshop')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($eshopId, $projectId, Request $request)
    {
        $messages = [
            'required' => trans('error.required'),
            'max' => trans('error.max_length'),
            'date_format' => trans('error.date_format')
        ];
        $niceNames = array(
            'body' => trans('log.body'),
            'date' => trans('log.date')
        );

        $dateFormat = trans('time.format');

        $validator = Validator::make($request->input(), [
            'date' => 'required|date_format:"'.$dateFormat.'"',
            'body' => 'required|max:1000',
        ], $messages);

        $validator->setAttributeNames($niceNames);


        if ($validator->fails()) {
            return redirect()->action('ProjectLogsController@create', ['eshop_id' => $eshopId, 'project_id' => $projectId])
                ->withErrors($validator)
                ->withInput();
        }

        $date = date_create_from_format($dateFormat, $request->input('date'));

        $log = Log::create([
            'date' => $date->format('Y-m-d H:i:s'),
            'body' => strip_tags($request->input('body')),
            'user_id' => $this->user,
            'project_id' => $projectId,
            'eshop_id' => $eshopId
        ]);

        if($request->input('fromEshop')) {
            return redirect()->action('EshopLogsController@index', [
                'eshop_id' => $eshopId
            ]);
        }

        return redirect()->action('ProjectLogsController@index', [
            'eshop_id' => $eshopId,
            'project_id' => $projectId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($eshopId, $projectId, $id)
    {

        $projectModel = new ProjectModel();
        $project = $projectModel->get($projectId);

        $log = Log::find($id);
        //if null redirect to error page/logs page
        if(!$log) {
            return redirect('error');
        }
        return view('project.logs.show')->with([
            'log' => $log,
            'project' => $project,
            'user' => $log->user()->first(),
            'logoLink' => action('ProjectLogsController@index', ['eshop_id' => $eshopId, 'projectId' => $projectId]),
            'eshopId' => $eshopId,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($eshopId, $projectId, $id)
    {

        $projectModel = new ProjectModel();
        $project = $projectModel->get($projectId);
        $log = Log::find($id);
        //if null redirect to error page/logs page
        if(!$log) {
            return redirect('error');
        }

        return view('project.logs.edit')->with([
            'log' => $log,
            'project' => $project,
            'user' => $log->user()->first(),
            'logoLink' => action('ProjectLogsController@index', ['eshop_id' => $eshopId, 'projectId' => $projectId]),
            'eshopId' => $eshopId,
            'fromEshop' => Input::get('eshop')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($eshopId, $projectId, $id, Request $request)
    {

        $messages = [
            'required' => trans('error.required'),
            'max' => trans('error.max_length'),
            'date_format' => trans('error.date_format')
        ];

        $niceNames = array(
            'body' => trans('log.body'),
            'date' => trans('log.date')
        );


        $dateFormat = trans('time.format');

        $validator = Validator::make($request->input(), [
            'date' => 'required|date_format:"'.$dateFormat.'"',
            'body' => 'required|max:1000',
        ], $messages);

        $validator->setAttributeNames($niceNames);


        if ($validator->fails()) {
            return redirect()->action('ProjectLogsController@edit', ['eshop_id' => $eshopId, 'project_id' => $projectId, 'id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $log = Log::find($id);

        $date = date_create_from_format($dateFormat, $request->input('date'));
        $log->date = $date->format('Y-m-d H:i:s');
        $log->body = strip_tags($request->input('body'));

        $log->save();

        if($request->input('fromEshop')) {
            return redirect()->action('EshopLogsController@index', [
               'eshop_id' => $eshopId
            ]);
        }

        return redirect()->action('ProjectLogsController@index', [
            'eshop_id' => $eshopId,
            'project_id' => $projectId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($eshopId, $projectId, $id)
    {
        $log = Log::destroy($id);
        return redirect()->action('ProjectLogsController@index', [
            'eshop_id' => $eshopId,
            'project_id' => $projectId
        ]);
    }

    public function export($eshopId, $projectId)
    {
        $projectModel = new ProjectModel();
        $project = $projectModel->get($projectId);

        $logs = Log::where('project_id', $projectId)
            ->join('users', 'logs.user_id', '=', 'users.id')
            ->orderBy('logs.date', 'desc')
            ->select('logs.body as ' . trans('log.body'), 'logs.date as '. trans('log.date'), 'users.name as ' . trans('log.user'))
            ->get();

        Excel::create('CSV-export-'.$project->name,
            function($excel) use ($logs, $project) {

            $excel->sheet('Sheetname', function($sheet) use ($logs, $project) {

                $sheet->fromModel($logs);

            });

        })->download('csv');
    }

    public function deleteLink($eshopId, $projectId, $id, Request $request) {
        $log = Log::destroy($id);

        if($request->input('eshop')) {
            return redirect()->action('EshopLogsController@index', [
                'eshop_id' => $eshopId
            ]);
        }

        return redirect()->action('ProjectLogsController@index', ['eshop_id' => $eshopId, 'project_id' => $projectId]);
    }

    public function widget($eshopId, $projectId) {

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
