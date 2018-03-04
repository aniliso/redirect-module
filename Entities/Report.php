<?php

namespace Modules\Redirect\Entities;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'redirect__reports';
    protected $fillable = ['url', 'ip', 'status_code', 'created_at', 'updated_at'];
    protected $with = ['redirect'];

    public function redirect()
    {
        return $this->belongsTo(Redirect::class, 'redirect_id', 'id');
    }
}
