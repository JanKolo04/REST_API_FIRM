<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

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
        $company = Company::where('nip', $nip)->first();

        if (!empty($company)) {
            return true;
        }

        return false;
    }
}
