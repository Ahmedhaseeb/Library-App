<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'isbn', 'qty','stock',
    ];

    public function getBookAuthors()
    {
    	return $this->belongsToMany('App\Authors', 'Books_authors', 'book_id', 'author_id');
    }
}
