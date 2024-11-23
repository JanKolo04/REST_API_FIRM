<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Employee;

class Company extends Model
{
    /** @var int $primaryKey */
    protected $primaryKey = 'id_company';

    /** @var string $table */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nip',
        'address',
        'city',
        'post_code',
    ];

    /**
     * Check exist of company
     * 
     * @param string $nip
     */
    public static function checkExistByNip(string $nip): bool
    {
        // try to find company by nip
        $company = static::where('nip', $nip)->first();

        if (!empty($company)) {
            return true;
        }

        return false;
    }

    /**
     * Validate length of nip filed
     * 
     * @param string $nip
     */
    public static function validateNip(string $nip): bool
    {
        $length = 10;

        if (strlen($nip) != 10 || !ctype_digit($nip)) {
            return false;
        }

        return true;
    }

    /**
     * Get employees
     */
    public function getEmployees()
    {
        return static::where('id_company', $this->id_company)
            ->get();
    }
}
