<?php
namespace App\Hooks;

use App\Auth;
use App\MergadoModels\ProjectModel;
use App\Models\Log as LogModel;
use Illuminate\Support\Facades\Log;

class CreateHook implements MergadoHook
{

    /**
     * @var
     */
    public $entityId;

    /**
     * CreateHook constructor.
     * @param $entityId
     */
    public function __construct($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * Fetch data that will be needed (like project data etc.)
     */
    public function run()
    {
        Log::info("App has been turned on", ["entity_id" => $this->entityId]);

        return response()->json(["message" => "Application successfuly enabled!"], 200);
    }
}