<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'customerNumber';
    public $timestamps = false;

    public function salesRep()
    {
        return $this->belongsTo(Employee::class, 'salesRepEmployeeNumber', 'employeeNumber');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customerNumber');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customerNumber');
    }
}
