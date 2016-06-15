<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MergadoClient\OAuth2\AccessToken;

class OfflineToken extends Model
{

    public $timestamps = false;
    protected $table = 'offline_tokens';
    public $primaryKey = "eshop_id";
    protected $fillable = [
        'eshop_id',
        'token',
        'expire_time'
    ];

    public static function getValidAccessToken($entityId)
    {
        //get token if it will be valid at least for next ten minutes
        $offlineToken = self::where("eshop_id", $entityId)->where("expire_time", ">", time() + 600)->first();
        if (!$offlineToken) return null;
        $accessToken = new AccessToken([
            "access_token" => $offlineToken["token"],
            "entity_id" => $offlineToken["eshop_id"],
            "expires" => $offlineToken["expire_time"]
        ]);

        return $accessToken;
    }
}