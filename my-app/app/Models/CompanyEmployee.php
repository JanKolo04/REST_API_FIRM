<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyEmployee extends Model
{
    /** @var int $primaryKey */
    protected $primaryKey = 'id_company_employee';

    /** @var string $table */
    protected $table = 'company_employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_company',
        'id_employee',
    ];

    /**
     * Check exist of employee in company
     * 
     * @param int $id_company
     * @param int $id_employee
     */
    public static function checkExist(
        int $id_company,
        int $id_employee
    ): bool {
        $check = static::where('id_company', $id_company)
            ->where('id_employee', $id_employee)
            ->first();
        if (!empty($check)) {
            return true;
        }

        return false;
    }
}
