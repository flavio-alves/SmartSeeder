<?php

use Illuminate\Database\Eloquent\Model;

/**
 * Class Seeder
 */
class Seeder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seeds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seed',
        'env',
        'batch'
    ];
}
