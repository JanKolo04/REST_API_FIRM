<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @var int $primaryKey */
    protected $primaryKey = 'id_employee';

    /** @var string $table */
    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
    ];

    /**
     * Check exist by email
     * 
     * @param string $email
     */
    public static function checkExistByEmail(string $email): bool
    {
        // try find employee by email
        $employee = static::where('email', $email)->first();

        if (!empty($employee)) {
            return true;
        }

        return false;
    }
    
    /**
     * Get employee id by email
     * 
     * @param string $email
     */
    public function getEmployeeByEmail(string $email): bool
    {
        $employee = static::where('email', $email)->first();
        if (!empty($employee) && 
            $employee->id_employee != $this->id_employee
        ) {
            return true;
        }

        return false;
    }

    /**
     * Validate phone number
     * 
     * @param string|null $phone
     */
    public static function validatePhone(?string $phone): bool
    {        
        if (!empty($phone) &&
            !preg_match('/^\+\d{1,3}\d{9}$/', $phone)
        ) {
            return false;
        }

        return true;
    }
}
