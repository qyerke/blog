<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function author()
    {
    	return $this->belongsTo(User::class, 'user_id'); //ukazivaem user_id because comments func named 'author', if names 'user', we not print 'user_id'
    }

    //razreshit comment ili net
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }
    public function disallow()
    {
        $this->status = 0;
        $this->save();
    }
    public function toogleStatus()
    {
        if($this->status == 0)
        {
            return $this->allow();
        }
        return $this->disallow();
    }
    public function remove()
    {
      $this->delete();
    }

}
