<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FailLog extends Model
{
    protected $fillable = [
        "request",
        "message"
    ];
    protected $table = "fail_logs";
    protected $primaryKey = "id";


}
