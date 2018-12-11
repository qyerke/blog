<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
	use Sluggable;


	protected $fillable = ['title','content', 'date', 'description'];

    public function category()
    {
    	return $this->belongsTo(Category::class); // post belongsTo/принадлежит category
    }

    public function author()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
    	return $this->belongsToMany(
    		Tag::class,
    		'post_tags',
    		'post_id',
    		'tag_id'
    	);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {
    	$post = new Post;
    	$post->fill($fields);
    	$post->user_id = 1;
    	$post->save();

    	return $post;
    }

    public function edit($fields)
    {
    	$this->fill($fields);
    	$this->save();
    }

    public function remove()
    {
    	$this->removeImage();
    	$this->delete();
    }
    public function uploadImage($image)
    {
        if($image == null){   return;    }
        $this->removeImage();
        $filename = str_random(10). '.'.$image->extension();
        $image->storeAs('uploads',$filename);
        $this->image = $filename;
        $this->save(); //and save new image
    }
    public function removeImage()
    {
        if($this->image != null){
            Storage::delete('uploads/'. $this->image); //delete old image
        }
    }
    public function setCategory($id)
    {
        if($id == null) { return; }
        $this->category_id = $id;
        $this->save();
    }
    public function setTags($ids)
    {
         if($ids == null) { return; }
         $this->tags()->sync($ids);

    }
		public function getTagsTitles()
		{
			//dd($this->tags->pluck('title')->all());
			return (!$this->tags->isEmpty())
							?   implode(', ', $this->tags->pluck('title')->all())
							: 'Нет тегов';
		}

    //dlya save posta
    public function setDraft()
    {
        $this->status = 0;
        $this->save();

    }
    public function setPublic()
    {
        $this->status = 1;
        $this->save();

    }
    public function toggleStatus($value)
    {
        if($value == null){
           return $this->setDraft();
        } else {
           return $this->setPublic();
        }
    }
    //end save

    //dlya save vida posta Recomended
    public function setFeatured()
    {
        $this->is_featured = 1;
        $this->save();

    }
    public function setStandart()
    {
        $this->is_featured = 0;
        $this->save();

    }
    public function toggleFeatured($value)
    {
        if($value == null){
           return $this->setStandart();
        } else {
           return $this->setFeatured();
        }
    }
    //end save

    //dlya poluchenia img posta
    public function getImage()
    {
        if( $this->image == null) {
            return 'uploads/no-img.png';
        }
        return '/uploads/'.$this->image;
    }

		public function getCategoryTitle()
    {
			 if(isset($this->category)){
				  return $this->category->title;
			}
        return 'Нет категории';
    }
		public function getCategorySlug()
		{
			if(isset($this->category)){
				return route('category.list', $post->getCategorySlug());
			}
			 return;
		}

    public function setDateAttribute($value)    //this setter. мы берем значение Date до записи в бд
    {
       $date = Carbon::createFromFormat('d/m/y', $value)->format('y-m-d'); //change date format for database
        $this->attributes['date'] = $date;
       //dd($date);
    }

    public function getDateAttriute($value)
	{
			$date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y'); //change date format for database
			return $date;
	}
    public function hasPrevious()
    {
        return self::where('id', '<', $this->id)->max('id');

    }
    public function getPrevious()
    {
        $postID = $this->hasPrevious(); //ID
        return self::find($postID);
    }
     public function hasNext()
    {
        return self::where('id', '>', $this->id)->get()->min('id');
    }
    public function getNext()
    {
        $post = $this->hasNext();
        return Post::find($post);
    }
		public function getComments()
		{
			return $this->comments->where('status', 1)->all();
		}
}
