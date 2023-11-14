<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryRate extends Model
{
    use HasFactory;

    protected $table = 'countryrate';   

    protected $fillable = [
        'id',
        'countrycode',
        'price',
        'currency'
    ] ;
}
