<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\userController;
use Session;
class menuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $userRole;
    public function __construct($foo = null) {
        //$this->middleware('auth');
        $this->userRole = Session::has('user_role') ? strtolower(Session::get('user_role')): 'guest';
        // echo $this->userRole;
    }

    public function menuCheck($active)
    {

        if($this->userRole == "admin"){
            $menu[0] = $this->getMenu($active);
            $menu[1] = "true";
            return $menu;
        }elseif($this->userRole == "student"){
            $menu[0] = $this->getStudentMenu($active);
            $menu[1] = "true";
            return $menu;
        }else{
            $menu[1] = "false";
            return $menu;
        }
    }
    public function getMenu($active)
    {

        if(!($this->userRole == "admin" )){

            $menu = $this->menuCheck($active);
            if($menu[1] == "true"){
                return $menu[0];
            }
        }
        $menu = [
          'Home' => [
            'icon-class' => 'fa fa-dashboard',
            'menu_class' => '',
            'rights' => 'admin',
            'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/admin',
            ],
          'Books' => [
            'icon-class' => 'fa fa-graduation-cap',
            'menu_class' => '',
            'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/books',
            'rights' => 'admin',
            'sub_menu' => [
              'Add New' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/books/create',
                'rights' => 'admin'
              ],
              'Edit / Update' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/books',
                'rights' => 'admin'
              ],
              'Issue Book' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/issue-book',
                'rights' => 'admin'
              ]
            ]
          ],
          'Authors' => [
          'icon-class' => 'fa fa-user',
          'rights' => 'admin',
          'menu_class' => '',
          'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/authors',
          'sub_menu' => [
              'Add New' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/authors/create',
                'rights' => 'admin'
              ],
              'Edit / Update' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/authors',
                'rights' => 'admin'
              ],
            ]
          ],
          'Assign Authors/Books' => [
            'icon-class' => 'fa fa-user',
            'menu_class' => '',
            'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/authors-books',
            'rights' => 'admin'
          ],
          'Reports' => [
            'icon-class' => 'fa fa-file',
            'menu_class' => '',
            'slug' => '#',
            'rights' => 'admin',
            'sub_menu' => [
              'All Books' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/reports/all-books',
                'rights' => 'admin'
              ],
              'Available Books' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/reports/avail-books',
                'rights' => 'admin'
              ],
              'All Books Issued' => [
                'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/reports/books-issued',
                'rights' => 'admin'
              ]
            ]
          ],
          'Register' => [
            'icon-class' => 'fa fa-user',
            'menu_class' => '',
            'slug' => route('register'),
            'rights' => 'admin'
          ]
        ];
                $menu[$active['main_menu']]['active'] = "";
                if(array_key_exists('sub_menu', $menu[$active['main_menu']])):
                    $menu[$active['main_menu']]['sub_menu'][$active['sub_menu']]['active'] = "";
                endif;
        return $menu;
    }

    public function getStudentMenu($active)
    {
        if(! ($this->userRole == "student")){
            $menu = $this->menuCheck($active);
            if($menu[1] == "true"){
                return $menu[0];
            }
        }
        $menu = [
          'All Books' => [
            'icon-class' => 'fa fa-book',
            'menu_class' => '',
            'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/student',
            'rights' => 'student'
            ],
          'Issued Books' => [
            'icon-class' => 'fa fa-book',
            'menu_class' => '',
            'slug' => 'http://'.$_SERVER['HTTP_HOST'].'/issued-books',
            'rights' => 'student'
            ],
          ];
          $menu[$active['main_menu']]['active'] = "";
          if(array_key_exists('sub_menu', $menu[$active['main_menu']])):
              $menu[$active['main_menu']]['sub_menu'][$active['sub_menu']]['active'] = "";
          endif;
          return $menu;
    }
}
