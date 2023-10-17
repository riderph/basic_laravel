<?php

namespace App\Models;

use App\Notifications\DeleteUserNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d H:i:s',
        'password' => 'hashed',
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * Route notifications for the Slack channel.
     *
     * @param  DeleteUserNotification  $notification
     * @return string
     */
    public function routeNotificationForSlack(DeleteUserNotification $notification)
    {
        return config('notification.slack.alert_webhook_url');
    }

    /**
     * Custom method to find the user for the Passport password grant.
     */
    public function findForPassport($email) {
        return self::where('email', $email)->first(); // change column name whatever you use in credentials
    }

    /**
     * Validate the password of the user for the Passport password grant.
     */
    public function validateForPassportPasswordGrant(string $password): bool
    {
        // Use can implement salt for password to increase security
        return Hash::check($password, $this->password);
    }
}
