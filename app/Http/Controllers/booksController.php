<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Books;
use App\User;
use App\Issued_Books;
use Illuminate\Support\Facades\Mail;
use App\Mail\bookIssueMail;
class booksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $menu  = new menuController();
      $active = [ 
        'main_menu' => 'Books',
        'sub_menu' => 'Edit / Update'
      ];
      $user = new userController();
      $role = $user->getUserRole($request);
      $menu = $menu->getMenu($active);
      $books = Books::all();
      return view('books.view', ['menu' => $menu, 'role' => $role, 'books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menu  = new menuController();
        $active = [ 
                    'main_menu' => 'Books',
                    'sub_menu' => 'Add New'
        ];
        $user = new userController();
        $role = $user->getUserRole($request);
        $menu = $menu->getMenu($active);
        return view('books.create',['menu' => $menu,'role' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
      $data = $request->all();
      $validator = $this->validator($data);
      if ($validator->fails()) {
        return redirect('/books/create')
              ->withErrors($validator)
              ->withInput();
      }else{
        $book = Books::create([
          'name' => $data['name'],
          'isbn' => $data['isbn'],
          'qty' => $data['qty'],
          'stock' => $data['stock']
        ]);
        if($book){
          return redirect('/books/create')->with('message','Book Inserted Successfully');
        }
      }
    }

    public function validator(array $data){
      return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'isbn' => ['required', 'string', 'max:255', 'unique:books,isbn'],
        'qty' => ['required', 'numeric'],
        'stock' => ['required', 'numeric'],
      ]);
    }
    public function bookUpdateValidator(array $data){
      return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'isbn' => ['required', 'string', 'max:255', 'unique:books,isbn,'.$data['id']],
        'qty' => ['required', 'numeric'],
        'stock' => ['required', 'numeric'],
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Books::find($id);
        return view('books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $data = $request->all();
      $data['id'] = $id;
      $validator = $this->bookUpdateValidator($data);
      if ($validator->fails()) {
        print_r($data);
        return redirect(route('books.index'))
              ->withErrors($validator)
              ->withInput();
      }else{
        $book = Books::find($id);
        $book->name = $request->name;
        $book->isbn = $request->isbn;
        $book->qty = $request->qty;
        $book->stock = $request->stock;
        $response = $book->save();
        if($response){
          return redirect(route('books.index'))->with('message','Record Updated');
        }
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Books::destroy($id);
        if($book){
          return redirect(route('books.index'))->with('message','Record Deleted');
        }else{
          return redirect(route('books.index'))->with('error','Failed To Delete Record');
        }
        // $book->destroy($id);
    }


    public function showIssueBookForm(Request $request){
      $menu  = new menuController();
      $active = [ 
        'main_menu' => 'Books',
        'sub_menu' => 'Issue Book'
      ];
      $user = new userController();
      $role = $user->getUserRole($request);
      $menu = $menu->getMenu($active);

      $books = Books::orderby('name', 'ASC')->get();
      $students = User::where('role', '=' , 'student')->orderby('name','ASC')->get();

      return view(
        'books.issueBook', 
        [
          'menu' => $menu, 
          'role' => $role, 
          'books' => $books, 
          'students' => $students
        ]
      );
    }
    public function issueBook(Request $request)
    {
      $book_id = $request->book_id;

      $student_id = $request->student_id;      
      $return_date = $request->returndate;
      $issue_date = $request->issuedate;
      $checkAlreadyIssue = Issued_Books::where([ ['book_id', '=' , $book_id], ['user_id', '=', $student_id] ])->get();
      
      if($checkAlreadyIssue->count() > 0){
        return redirect(route('issueBookForm'))->with('error', 'Book Already Issued');
      }else{
        $response = Issued_Books::create([
          'book_id' => $book_id,
          'user_id' => $student_id,
          'return_date' => $return_date,
          'issue_date' => $issue_date
        ]);
        if($response){
          $user = User::find($student_id);
          $book = Books::find($book_id);
          $book->stock = $book->stock-1;
          $book->save(); 
          $data = array();
          $data['name'] = $book->name;
          $data['issue_date'] = $issue_date;
          $data['return_date'] = $return_date;
          $data['to'] = $user->email;
          $this->sendMail($data);
          return redirect(route('issueBookForm'))->with('message', 'Book Issued');
        }
      }
      return $request->input();
    }

    public function sendMail($data)
    {   
      // print_r($data);
      // die();
      // return;
        $name = $data['name'];
        $issue_date = $data['issue_date'];
        $return_date = $data['return_date'];
        $msg = "Book $name has been issued";
        $to  = $data['to']; //'ahmedhaseeb123@gmail.com';        
        $subject = "Book \"$name\" has been issued";
        
        // Mail it
        $data = [ 
          'subject' => $subject,
          'name' => $name,
          'return_date' => $return_date,
          'issue_date' => $issue_date,
          'msg' => $msg,
        ];
        $bookIssueMail = new bookIssueMail($data);
        $response = Mail::to($to)->send($bookIssueMail);
    }
}