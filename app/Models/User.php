<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
/**
 * Class User
 * @package App\Models
 * @version March 30, 2021, 5:23 pm UTC
 *
 * @property string $name
 * @property string $user_name
 * @property string $avatar
 * @property string $email
 * @property string $user_role
 * @property string|\Carbon\Carbon $registered_at
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $api_token
 * @property string $remember_token
 */
class User extends Model implements HasMedia

{

    use HasFactory,InteractsWithMedia;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_name',
        'avatar',
        'email',
        'user_role',
        'registered_at',
        'email_verified_at',
        'password',
        'api_token',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_name' => 'string',
        'avatar' => 'string',
        'email' => 'string',
        'user_role' => 'string',
        'registered_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'api_token' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_name' => 'required|string|max:20|min:4',
        'avatar' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        'email' => 'required|string|max:255',
        'user_role' => 'required|string|max:255',

        'password' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function setPasswordAttribute($value){
        $this->attributes["password"] = Hash::make($value);
    }

    protected $hidden =["password"];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(256)
              ->height(256)
              ->sharpen(10);
    }

}
