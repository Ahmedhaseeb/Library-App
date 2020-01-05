<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Authors;
use App\Books;
use App\Books_authors;

class authorsController extends Controller
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
          'main_menu' => 'Authors',
          'sub_menu' => 'Edit / Update'
        ];
        $user = new userController();
        $role = $user->getUserRole($request);
        $menu = $menu->getMenu($active);
        $authors = Authors::orderBy('name', 'asc')->get();
        return view('authors.view', ['menu' => $menu, 'role' => $role, 'authors' => $authors]);
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
                    'main_menu' => 'Authors',
                    'sub_menu' => 'Add New'
        ];
        $user = new userController();
        $role = $user->getUserRole($request);
        $menu = $menu->getMenu($active);
        return view('authors.create',['menu' => $menu,'role' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      $validator = $this->validator($data);
      if ($validator->fails()) {
        return redirect('/authors/create')
              ->withErrors($validator)
              ->withInput();
      }else{
        $author = Authors::create([
          'name' => $data['name']
        ]);
        if($author){
          return redirect('/authors/create')->with('message','Author Inserted Successfully');
        }
      }
    }

    public function validator(array $data){
      return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
      ]);
    }
    public function bookUpdateValidator(array $data){
      return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
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
      $author = Authors::find($id);
      return view('authors.edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
      $data = $request->all();
      $validator = $this->bookUpdateValidator($data);
      if ($validator->fails()) {
        print_r($data);
        return redirect(route('authors.index'))
              ->withErrors($validator)
              ->withInput();
      }else{
        $author = Authors::find($id);
        $author->name = $request->name;
        $response = $author->save();
        if($response){
          return redirect(route('authors.index'))->with('message','Author Updated');
        }
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
      $author = Authors::destroy($id);
      if($author){
        return redirect(route('authors.index'))->with('message','Record Deleted');
      }else{
          return redirect(route('authors.index'))->with('error','Failed To Delete Record');

      }
    }

    function getAuthorsByBookId(Request $request){
      $book_id = $request->id;

      $authors = Books_authors::where('book_id', '=', $book_id)->get();
      
      // $authors = Books::find($book_id)->getBookAuthors()->get();
      return $authors->toJson();
    }

    public function showBookAuthorsForm(Request $request){
      $menu  = new menuController();
      $active = [ 
                  'main_menu' => 'Assign Authors/Books',
      ];
      $user = new userController();
      $role = $user->getUserRole($request);
      $menu = $menu->getMenu($active);

      $books = Books::orderBy('name', 'ASC')->get();
      $authors = Authors::orderBy('name', 'ASC')->get();

      return view('authors.authorsBooksForm',['menu' => $menu, 'role' => $role, 'books' => $books,'authors' => $authors]);
    }

    public function storeBookAuthors(Request $request){
      $errors = false;
      $pass = false;
      print_r($request->input());
      $book = $request->book;
      $authors = $request->authors;
      $delete = Books_authors::where('book_id', '=', $book)->delete();
      if(!$delete){
        echo "Failed To Delete";
      }
      foreach ($authors as $value) {
        // $checkAuthor = Books_authors::where([ ['book_id', '=', $book],['author_id', '=', $value] ])->get();
        // if($checkAuthor->count() > 0){
        //   $errors[] = "Author with id: $value already assigned";
        // }else{
          $response = Books_authors::create([
            'book_id' => $book,
            'author_id' => $value
          ]);
          // $pass = true;
          if(!$response){
            echo "Failed To Insert Some Authors";
          }
        // }
      }
      // if($errors and !$pass){
      //   return redirect(route('bookAuthorsForm'))->with('customErrors', ["All Authors Already Assigned."]);
      // }elseif($errors and $pass){
      //   return redirect(route('bookAuthorsForm'))->with('customErrors', ["Authors Assigned Successfully", "Some Already Assigned Authors Skipped"]);
      // }else{
        return redirect(route('bookAuthorsForm'))->with('message', "Authors Assigned Successfully");
      // }
    }
}
