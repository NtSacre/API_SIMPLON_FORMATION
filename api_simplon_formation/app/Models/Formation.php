<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Formation_user;

class Formation extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];
     /**
     * Get the Candidat for the projet.
     */
    public function Candidat(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
      /**
     * Get the Formation_user for the formation.
     */
    public function formationCandidater(): HasMany
    {
        return $this->HasMany(Formation_user::class);
    }
}
