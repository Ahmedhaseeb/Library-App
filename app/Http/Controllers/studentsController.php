<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class studentsController extends Controller
{
  public function getAvailableBooks(Request $request){
  	$menu  = new menuController();
    $active = [ 
      'main_menu' => 'All Books'
    ];
    $user = new userController();
    $role = $user->getUserRole($request);
    $menu = $menu->getMenu($active);
  	$books = DB::select('SELECT books.`id`,`books`.`name` as `book_name`, group_concat(`authors`.`name`) as `author_name`, `books`.`isbn`, `books`.`qty`, `books`.`stock`, `books`.`id` 
		from `books_authors` 
		inner join `books` 
		on `books_authors`.`book_id` = `books`.`id` 
		inner join `authors` 
		on `books_authors`.`author_id` = `authors`.`id`
		-- inner join `issued_books`
		-- on `issued_books`.
		where books.`stock` > 0
		group by books.`id`');
		// return $books;
		return view('students.availableBooks',['menu' => $menu, 'role' => $role, 'books' => $books]);
    	// return view('students.availableBooks');
  }
  public function issuedBooks(Request $request)
  {
  	$menu  = new menuController();
    $active = [ 
      'main_menu' => 'Issued Books'
    ];
    $menu = $menu->getMenu($active);
    $user = new userController();
    $role = $user->getUserRole($request);
   	$user_id = $request->session('user_id')->get('user_id');
  	$books = DB::select('SELECT `books`.`name` as book_name, group_concat(`authors`.`name`) as author_name, `books`.`isbn`, `issued_books`.`issue_date`, `issued_books`.`return_date` 
  		FROM `issued_books`
  		INNER JOIN `books`
  		ON `issued_books`.`book_id` = `books`.`id`
  		INNER JOIN `books_authors`
  		ON `books_authors`.`book_id` = `issued_books`.`book_id`
  		INNER JOIN `authors`
  		ON `authors`.`id` = `books_authors`.`author_id`
  		WHERE `issued_books`.`user_id` = ' . $user_id . 
  		' group by `issued_books`.`id`');
  	// return $books;
  		return view('students.issuedBooks', ['menu' => $menu, 'role' => $role, 'books' => $books]); 
  }

}
