<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new User;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {

        $this->fill($fields); //name,email
        if ($fields['password'] != null) {
        $this->password = bcrypt($fields['password']);
        }
        $this->save();
    }

    public function remove() //for delete image and user
    {
        $this->removeAvatar();
        $this->delete();
    }

    public function uploadAvatar($avatar)
    {
        if($avatar == null){   return;    }
        //    dd(get_class_methods($image)); смотрим методы $image
        $this->removeAvatar();

        $filename = str_random(10). '.'.$avatar->extension();
        $avatar->storeAs('uploads',$filename);
        $this->avatar = $filename;
        $this->save(); //and save new image
    }
    public function removeAvatar()
    {
      if($this->avatar != null  ) {
           Storage::delete('uploads/'. $this->avatar); //delete old image
      }
    }
    public function getAvatar()
    {
        if($this->avatar == null )
        {
            return '/img/no-image.png';
        }
        return '/uploads/'.$this->avatar;
    }

    // dlya ustanovki admina
    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }
    public function makeNormal()
    {
        $this->is_admin = 0;
        $this->save();
    }
    public function toogleAdmin($value)
    {
        if($value==null)
        {
            return $this->makeNormal();
        }
        return $this->makeAdmin();
    }


    //dlya ban ili no ban usera
    public function setBan()
    {
       $this->status = 1;
       $this->save();
    }
    public function setNoBan()
    {
        $this->status = 0;
        $this->save();
    }
    public function toogleBan($value)
    {
        if($value == null)
        {
            return $this->setNoBan();
        }
        return $this->setBan();
    }
}
