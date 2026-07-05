<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRules extends Model
{
    protected $table = 'contract_rules';

    protected $fillable = [
        'contract_rules',
        'is_active'
    ];
}
