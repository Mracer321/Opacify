<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'country_code',
        'phone',
        'company',
        'technology',
        'budget_type',
        'project_description',
        'source',
    ];
}
