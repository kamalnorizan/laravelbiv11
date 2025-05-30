<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
     protected $table = 'employees';
    protected $primaryKey = 'employeeNumber';
    public $timestamps = false;

    public function office()
    {
        return $this->belongsTo('Offices', 'officeCode', 'officeCode');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'salesRepEmployeeNumber');
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'reportsTo', 'employeeNumber');
    }

    public function subordinates()
    {
        return $this->hasMany('Employees', 'reportsTo');
    }
}
