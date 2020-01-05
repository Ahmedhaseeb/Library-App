<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issued_Books extends Model
{
	/**
   * The attributes that are mass assignable.
   *
   * @var array
   */
	protected $table = "issued_books";
	protected $fillable = [
      'book_id', 'user_id', 'issue_date','return_date',
  ];
}
