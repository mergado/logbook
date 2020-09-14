<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HookController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        if(!isset($data["action"])) {
            return response()->json(["message" => "Action undefined!"], 400);
        }

        switch ($data["action"]) {
            case "ping":
                return response()->json(["message" => "pong"], 200);
            case "app.enable":
                return response()->json(["message" => "enabled"], 200);
            case "app.disable":
                return response()->json(["message" => "disabled"], 200);
            default:
                return response()->json(["message" => "Unsupported action!"], 400);
        }

    }
}
