<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'sid', 'name', 'email', 'recovery_email', 'phone', 'password',
        'timezone_id', 'pkcs12', 'last_login', 'terms', 'api_token', 'locked',
        'phone_secondary', 'country', 'state', 'city', 'type', 'date_of_birth', 'ldap_user',
        'recovery_email', 'token_2fa', 'token_2fa_expiry', 'change_password',
        'login_attempts', 'login_max_attempts', 'job_and_position_id',
        'disadvantaged', 'google2fa_secret', 'otp_secret', 'otp_exemption',
        'user_status_id', 'avatar_file_id', 'employee'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fname() {
        return explode(' ', $this->getAttribute('name'))[0];
    }

    public function account() {
        return $this->hasOne(Account::class);
    }

    public function setting() {
        return $this->hasOne(Setting::class);
    }

    public function sessions() {
        return $this->hasMany(UserSession::class);
    }

    public function session() {
        return $this->hasMany(UserSession::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function lockAccount() {
        return $this->setAttribute('locked', true);
    }

    public function unlockAccount() {
        return $this->setAttribute('locked', false);
    }

    public function userType() {
        return $this->hasOne(UserType::class);
    }

    public function getTimezone() {
        $timezone = Timezone::find($this->getAttribute('timezone_id'));
        return $timezone->value;
    }

    public function createSid() {
        $name = explode(' ', $this->getAttribute('name'));
        $limit = 5;
        if (is_array($name)) {
            if (count($name) >= 2) {
                if (strlen($name[1]) < $limit) {
                    $name[1] = substr($name[1], 0, 6);
                }

                $sid = $name[0][0] . $name[1];
                if (User::where('sid', $sid)->exists()) {
                    list($alpha, $numeric) = sscanf($sid, "%[a-zA-Z]%d");

                    $sid = $alpha . ($numeric + 1);
                }
                return strtolower($sid);
            }
        }
        return 'error';
    }

    public function getAvatarUrl() {
        if (!is_null($this->getAttribute('avatar_file_id'))) {
            $avatar = File::find($this->getAttribute('avatar_file_id'));
            return route("get-avatar", ['user_uid' => $this->getAttribute('uid'), 'uuid' => $avatar->uuid, 'name' => $avatar->name]);
        }
    }
}
