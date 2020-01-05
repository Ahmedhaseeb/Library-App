<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books_authors extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'book_id', 'author_id'
  ];
}
