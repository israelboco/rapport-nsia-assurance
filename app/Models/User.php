<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'code_unique', 'profile',
        'role_id', 'telephone', 'domicile', 'ifu',
        'compte_bancaire', 'service_id', 'supervisor_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peutVoir(User $agent)
    {
        return $this->role->niveau > $agent->role->niveau;
    }

    public function chiffreAffairesDuJour($date)
    {
        return $this->contrats()
                    ->where('statut', 'à conclure')
                    ->whereDate('date_conclusion', $date)
                    ->sum('montant');
    }

    public function tousLesSubordonnés()
    {
        return $this->subordinates()->with('tousLesSubordonnés');
    }
}
