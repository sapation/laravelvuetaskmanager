<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskProgress extends Model
{
    use HasFactory;
    const NOT_PINNED_ON_DASHBOARD = 0;
    const PINNED_ON_DASHBOARD = 1;

    /**
     * Project Percent
     */
    const INITIAL_PROJECT_PERCENT = 0;

    protected $guarded = [];
}
