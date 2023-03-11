<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleSettingItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setting() {
        $this->hasOne(Setting::class);
    }
}
