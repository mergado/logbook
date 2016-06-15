<?php
namespace App\Hooks;

use App\Models\Log as LogModel;
use App\Models\OfflineToken;
use Illuminate\Support\Facades\Log;

class DeleteHook implements MergadoHook
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
    public function run() {
        LogModel::where("eshop_id", $this->entityId)->delete();
        OfflineToken::where("eshop_id", $this->entityId)->delete();
        Log::info("App has been turned off", ["entity_id" => $this->entityId]);

        return response()->json(["message" => "Application successfuly disabled!"], 200);
    }
}