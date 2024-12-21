<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	protected $table = 'stores';
	protected $fillable = [
        'shopname','token',
    ];
}