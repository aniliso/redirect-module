<?php

namespace Modules\Redirect\Entities;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $table = 'redirect__redirects';
    protected $fillable = ['from', 'to', 'status', 'created_at', 'updated_at'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
