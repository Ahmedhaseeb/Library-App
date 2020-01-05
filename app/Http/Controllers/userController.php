<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;
class userController extends Controller
{
  private $id;
  private $name;
  private $email;
  private $role;

	public function logout(Request $request){
	    $request->session()->flush();
	    Session::flush();
	    return redirect('/');
	}

  public function is_login($request){
    if($this->is_admin($request)){
      return "admin";
    }elseif($this->is_student($request)){
      return "student";
    }
    return false;
  }

  public function is_admin($request){
    if($request->session()->has('user_role') AND $request->session()->get('user_role') == "admin"){
      return true;
    }else{
      return false;
    }
  }

  public function is_student($request){
    if($request->session()->has('user_role') AND $request->session()->get('user_role') == "student"){
      return true;
    }else{
      return false;
    }
  }

	public function getUserRole($request){
      $this->role = $request->session()->get('user_role');
      return strtolower($this->role);
  }

	public function allowed($request,$role)
	{
	  if($role == "all"){
	    return true;
	  }else{
	    $userRole = $this->getUserRole($request);
	    $roles = explode('|',$role);
	    foreach ($roles as $key => $value) {
	        if($userRole == strtolower($value) )
	            return true;
	    }
	  }
	  return false;
	}

	private function storeDetails($data,$request){
    foreach ($data as $key => $value) {
      $request->session()->put($key,$value);
    }
  }

	public function checkLogins($request){
    $email = $request->email;
    $password = $request->password;
    $user = new User();
    $userData = $user::where([ ['email' , '=' , $email] ])->get();
    if( $userData->count()>0){
	    $userPwdHash = $userData[0]->password;
	    $user_pass_verify = password_verify($password , $userPwdHash);
	    if($user_pass_verify){
        $this->name = $userData[0]->name;
        $this->email = $userData[0]->email;
        $this->id = $userData[0]->id;
        $this->role = $userData[0]->role;
        $data = [
          'user_login' => true,
          'user_role' => $this->role,
          'user_email' => $this->email,
          'user_name' => $this->name,
          'user_id' => $this->id,
    		];
	      $this->storeDetails($data,$request);
	      return $this->role;
	    }
    }
    return false;
  }

	public function loginUser(Request $request){
		$response = strtolower($this->checkLogins($request));
	  // $response = strtolower($this->loginUser2($request));
	  if($response == 'admin'){
	      return redirect('/admin');
	  }elseif($response == 'student'){
	      return redirect('/student');
	  }else{
	      return redirect('/login')->with('message', 'Wrong Login Details');
	  }
	}

	public function showRegisterUserForm(Request $request){
    $menu  = new menuController();
    $active = [ 
      'main_menu' => 'Register'
    ];
    $user = new userController();
    $role = $user->getUserRole($request);
    $menu = $menu->getMenu($active);
		return view('auth.register',['menu' => $menu, 'role' => $role]);
	}

	public function registerUser(Request $request){
		$data = $request->all();
		$validator = $this->validator($data);
		if ($validator->fails()) {
	      return redirect('/register')
	                  ->withErrors($validator)
	                  ->withInput();
	  }else{
      if($this->is_admin($request)){
        if($request->has('user_role')){
          $data['user_role'] = $request->user_role; 
        }else{
          $data['user_role'] = "student"; // Default User
        }
      }else{
        $data['user_role'] = "student"; // Default User
      }
			$userId = $this->create($data);
			if($userId){
        return redirect(route('login'))->with('message', 'User Registered Successfully');
				 // print_r(json_decode($userId,true));
			}
		}
	}

	public function validator(array $data){
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  public function create(array $data){
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'role' => $data['user_role']
    ]);
  }

	public function showLoginForm(Request $request){
    $menu  = new menuController();
    $active = [ 
      'main_menu' => 'Reports',
      'sub_menu' => 'All Books'
    ];
    $user = new userController();
    $role = $user->getUserRole($request);
    $menu = $menu->getMenu($active);

    $redirect = $this->is_login($request);
    if(!$redirect)
      return view('auth.login',['request' => $request, 'user' => $this,'role' => $role, 'menu' => $menu]);
    else
      return redirect('/' . $redirect);
  }

}