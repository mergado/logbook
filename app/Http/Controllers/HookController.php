<?php

namespace App\Http\Controllers;

use App\Hooks\CreateHook;
use App\Hooks\DeleteHook;
use Illuminate\Http\Request;

use App\Http\Requests;

class HookController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        if(!isset($data["action"])) {
            return response()->json(["message" => "Action undefined!"], 400);
        }

        switch ($data["action"]) {
            case "app.enable":
                $hook = new CreateHook($data["entity_id"]);
                break;
            case "app.disable":
                $hook = new DeleteHook($data["entity_id"]);
                break;
            default:
                return response()->json(["message" => "Unsupported action!"], 400);
        }

        return $hook->run();
    }
}
