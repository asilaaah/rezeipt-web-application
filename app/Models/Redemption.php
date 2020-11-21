<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Redemption extends Model
{
    use HasFactory, Sortable;

    public $timestamps = false;

    protected $table = 'redemption';

    protected $fillable = [
        'name','description','points','discountAmount','expirationDate'
    ];

    public $sortable = ['name','description','points','discountAmount','expirationDate'];
}