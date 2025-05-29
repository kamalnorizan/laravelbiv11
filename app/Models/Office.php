<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = 'offices';
    protected $primaryKey = 'officeCode';
    public $incrementing = true;
    protected $keyType = 'string';
    public $timestamps = false;

    public function employees()
    {
        return $this->hasMany(Employee::class, 'officeCode');
    }
}
