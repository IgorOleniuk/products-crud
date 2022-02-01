<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function report_views()
    {
        return $this->belongsToMany(User::class, 'report_views')->withPivot('views')->withTimestamps();
    }

    public function purchased()
    {
        return $this->belongsToMany(User::class, 'reports')
            ->withPivot('amount', 'quantity')
            ->withTimestamps();
    }
}
