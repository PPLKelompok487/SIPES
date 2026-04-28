<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'location', 'description', 'photo_path', 'status', 'latitude', 'longitude'])]
class Report extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
