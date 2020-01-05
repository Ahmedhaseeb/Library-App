<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class reportsController extends Controller
{

  function getAllBooks(Request $request)
  {
  	$menu  = new menuController();
    $active = [ 
      'main_menu' => 'Reports',
      'sub_menu' => 'All Books'
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
		group by books.`id`');
		// return $books;
		return view('reports.view-all-books',['menu' => $menu, 'role' => $role, 'books' => $books]);
  }

  public function booksIssued(Request $request)
  {
    $menu  = new menuController();
    $active = [ 
      'main_menu' => 'Reports',
      'sub_menu' => 'All Books Issued'
    ];
    $user = new userController();
    $role = $user->getUserRole($request);
    $menu = $menu->getMenu($active);

    // $books = DB::select('SELECT `books`.`name` as book_name, 
    //                       group_concat(distinct(`authors`.`name`)) as author_name, 
    //                       COUNT(DISTINCT(`users`.`name`)) as username,
    //                       `books`.`isbn`,
    //                       `books`.`qty`,
    //                       `books`.`stock`,
    //                       `issued_books`.`issue_date`,
    //                       `issued_books`.`return_date` 
    //   FROM `issued_books`
    //   INNER JOIN `books`
    //   ON `issued_books`.`book_id` = `books`.`id`
    //   INNER JOIN `books_authors`
    //   ON `books_authors`.`book_id` = `issued_books`.`book_id`
    //   INNER JOIN `authors`
    //   ON `authors`.`id` = `books_authors`.`author_id`
    //   INNER JOIN `users`
    //   ON `issued_books`.`user_id` = `users`.`id`
    //   GROUP BY  books.`id`');



    $books = DB::select('SELECT `books`.`name` as book_name, 
                          group_concat(`authors`.`name`) as author_name, 
                          `users`.`name` as username,
                          `books`.`isbn`,
                          `books`.`qty`,
                          `books`.`stock`,
                          `issued_books`.`issue_date`,
                          `issued_books`.`return_date` 
      FROM `issued_books`
      INNER JOIN `books`
      ON `issued_books`.`book_id` = `books`.`id`
      INNER JOIN `books_authors`
      ON `books_authors`.`book_id` = `issued_books`.`book_id`
      INNER JOIN `authors`
      ON `authors`.`id` = `books_authors`.`author_id`
      INNER JOIN `users`
      ON `issued_books`.`user_id` = `users`.`id`
      GROUP BY  issued_books.`id`');
    // return $books;
      return view('reports.booksTaken', ['menu' => $menu, 'role' => $role, 'books' => $books]);
  }

  public function availableBooks(Request $request)
  {
    $menu  = new menuController();
    $active = [ 
      'main_menu' => 'Reports',
      'sub_menu' => 'Available Books'
    ];
    $user = new userController();
    $role = $user->getUserRole($request);
    $menu = $menu->getMenu($active);


    $books = DB::select('SELECT `books`.`name` as book_name, group_concat(`authors`.`name`) as author_name, `books`.`isbn`, `books`.`qty`, `books`.`stock` 
      FROM `books`
      INNER JOIN `books_authors`
      ON `books_authors`.`book_id` = `books`.`id`
      INNER JOIN `authors`
      ON `authors`.`id` = `books_authors`.`author_id`
      WHERE `books`.`stock` > 0
      GROUP BY  `books`.`id`');


    return view('reports.availableBooks', ['menu' => $menu, 'role' => $role, 'books' => $books]);
    
  }
}
