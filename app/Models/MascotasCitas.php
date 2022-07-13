<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MascotasCitas extends Model
{
    protected $table = "citas_medica_mascota";
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "mascota_id",
        "fecha_agendamiento",
    ];
}
