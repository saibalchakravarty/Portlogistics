<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $table = 'export_db';
    /**
     * @var array
     */
    protected $fillable = ['export_key', 'model_name', 'db_column', 'excel_column', 'model_function'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
