<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\User;
use App\Message;
Use App\Operator;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class AuthController extends Controller
{
    //user login
    public function index()
    {
      return view('login');
    }

    //user login
    public function indexlogin2()
    {
      return view('login2');
    }

    //userlist login
    public function indexlogin3()
    {
      return view('login3');
    }

    //operator login
    public function indexoperatorlogin()
    {
      return view('operatorlogin');
    }
    
    //moderator login
    public function indexmoderatorlogin()
    {
      return view('moderatorlogin');
    }

    //moderator 404
    public function userlist()
    {
      return view('userlist');
    }

    //userlist
    public function notfound()
    {
      return view('404');
    }

    //check user auth login at dashboard
    public function dashboard(Request $request)
    {
      if(Auth::check()){
        $booth = $request->session()->get('booth');

        if($booth != null){
          $contact =  User::where('booth', '=', $booth)->value('id');
          $contactname = User::where('booth', '=', $booth)->value('loginotp');
          $authusername = Auth::user()->loginotp;
          if(Message::where('from', '=', $contact)->where('to', "=", auth()->id())->exists()){
            error_log('Already exist in message table');
          }else{
            // $welcometext = User::where('booth', '=', $booth)->value('welcometext');
            $welcometext = User::where('booth', '=', $booth)->value('welcometext');

            if($welcometext === null){
              $message = Message::create([
                'from' => $contact,
                'to' => auth()->id(),
                // 'text' => 'Hi there! Thank you for your message. Our support team will be actively available from 9am – 6pm, daily. Please leave your name, contact details, project of interest and our representative will get back to you as soon as we can.'
                // 'text' => 'Hi there! My name is ' . $authusername . ' and I would like to initiate conversation. Thank you'
                'text' => 'Hi there! Start a conversation by typing in the message box below.'
            ]);
            }else{
              $message = Message::create([
                'from' => $contact,
                'to' => auth()->id(),
                'text' => $welcometext
            ]);
            }
          }
        }

        return view('dashboard');
      }
      return Redirect::to("login")->withSuccess('Opps! You do not have access');
    }

    //check operator auth login at dashboard
    public function dashboard2()
    {
      if(Auth::check()){
        return view('dashboard2');
      }
      return Redirect::to("operatorlogin")->withSuccess('Opps! You do not have access');
    }

    //User login
    public function postLogin(Request $request)
    {
        //check booth exist
        $boothexist = User::where('booth', '=', $request->input('booth'))->first();

        if($boothexist != null){

          //capture booth id from url
          $booth = $request->input('booth');

          //check loginotp exist
          $user = User::where('loginotp', '=', $request->only('loginotp'))->first();

          //get operator name
          // $operator = User::where('', '=', $request->only(''))->first();
          $booth = $request->session()->get('booth');

          //check credential correct
          $login = User::where([
            'loginotp' => $request->loginotp, 
            'password' => $request->password,
          ])->first();

          //validate request
          request()->validate([
          'loginotp' => 'required',
          'password' => 'required',
          ]);
          
          //if user exist login or create new user and auto login
          if ($user != null) {
            if($login){
              // Authentication passed...
              Auth::login($login);
              $request->session()->forget('booth');
              $request->session()->put('booth', $booth);
              return redirect()->intended('dashboard');
            }else{
              return Redirect::to("login")->withSuccess('Oppes! You have entered invalid credentials');
            }
          }else{
              $data = $request->all();
              $check = $this->create($data);

              //check credential correct after create user
              $login2 = User::where([
                'loginotp' => $request->loginotp, 
                'password' => $request->password,
              ])->first();

              if($login2){
                // Authentication passed...
                Auth::login($login2);
                $request->session()->forget('booth');
                $request->session()->put('booth', $booth);
                return redirect()->intended('dashboard');
              }
          }

        }else{
          return view('404');
        }

    }

    //User login no room 
    public function postLogin2(Request $request){
      //capture booth id from url
      // $booth = $request->input('booth');
    
      //check loginotp exist
      $user = User::where('loginotp', '=', $request->only('loginotp'))->first();
    
      //get operator name
      // $operator = User::where('', '=', $request->only(''))->first();
      // $booth = $request->session()->get('booth');
    
      //check credential correct
      $login = User::where([
        'loginotp' => $request->loginotp, 
        'password' => $request->password,
      ])->first();
    
      //validate request
      request()->validate([
        'loginotp' => 'required',
        'password' => 'required',
      ]);
            
      //if user exist login or create new user and auto login
      if ($user != null) {
        if($login){
          // Authentication passed...
          Auth::login($login);
          $request->session()->forget('booth');
          // $request->session()->put('booth', $booth);
          return redirect()->intended('dashboard');
        }else{
          return Redirect::to("login")->withSuccess('Oppes! You have entered invalid credentials');
        }
      }else{
          // $data = $request->all();
          // $check = $this->create($data);
    
          // //check credential correct after create user
          // $login2 = User::where([
          //   'loginotp' => $request->loginotp, 
          //   'password' => $request->password,
          // ])->first();
    
          // if($login2){
          //   // Authentication passed...
          //   Auth::login($login2);
          //   $request->session()->forget('booth');
          //   // $request->session()->put('booth', $booth);
          //   return redirect()->intended('dashboard');
          // }
          return view('404');
      }
    }

    //User login userlist
    public function postLogin3(Request $request){
      //capture booth id from url
      // $booth = $request->input('booth');
    
      //check loginotp exist
      $user = User::where('loginotp', '=', $request->only('loginotp'))->first();
    
      //get operator name
      // $operator = User::where('', '=', $request->only(''))->first();
      // $booth = $request->session()->get('booth');
    
      //check credential correct
      $login = User::where([
        'loginotp' => $request->loginotp, 
        'password' => $request->password,
      ])->first();
    
      //validate request
      request()->validate([
        'loginotp' => 'required',
        'password' => 'required',
      ]);
            
      //if user exist login or create new user and auto login
      if ($user != null) {
        if($login){
          // Authentication passed...
          Auth::login($login);
          $request->session()->forget('booth');
          // $request->session()->put('booth', $booth);
          return redirect()->intended('userlist');
        }else{
          return Redirect::to("login")->withSuccess('Oppes! You have entered invalid credentials');
        }
      }else{
          // $data = $request->all();
          // $check = $this->create($data);
    
          // //check credential correct after create user
          // $login2 = User::where([
          //   'loginotp' => $request->loginotp, 
          //   'password' => $request->password,
          // ])->first();
    
          // if($login2){
          //   // Authentication passed...
          //   Auth::login($login2);
          //   $request->session()->forget('booth');
          //   // $request->session()->put('booth', $booth);
          //   return redirect()->intended('dashboard');
          // }
          return view('404');
      }
    }

    //operatorlogin
    public function postoperatorLogin(Request $request)
    {
        //check credential correct
        $login = User::where([
          'loginotp' => $request->loginotp, 
          'password' => $request->password
        ])->first();

        //validate request
        request()->validate([
          'loginotp' => 'required',
          'password' => 'required',
        ]);
        
        //if operator exist login
        if($login){
          // Authentication passed...
          Auth::login($login);
          return redirect()->intended('dashboard2');
        }else{
          return Redirect::to("operatorlogin")->withSuccess('Oppes! You have entered invalid credentials');
        }  
    }

    //moderator login
    public function postmoderatorLogin(Request $request)
    {
        //check credential correct
        $login = User::where([
          'loginotp' => $request->loginotp, 
          'password' => $request->password
        ])->first();

        //validate request
        request()->validate([
          'loginotp' => 'required',
          'password' => 'required',
        ]);
        
        //if moderator exist login
        if($login){
          // Authentication passed...
          Auth::login($login);
          return redirect()->intended('products');
        }else{
          return Redirect::to("moderatorlogin")->withSuccess('Oppes! You have entered invalid credentials');
        } 
    }

    //create user function
    public function create(array $data)
    {
      return User::create([
        'loginotp' => $data['loginotp'],
        'password' => $data['password'],
        'role' => 'user'
      ]);
    }

    //create operator function
    public function createoperator(array $data)
    {
      return User::create([
        'loginotp' => $data['loginotp'],
        'password' => $data['password'],
        'role' => 'operator',
        'booth' => $data['booth']
      ]);
    }
     
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('moderatorlogin');
    }

    public function createnewuserapi($name, $email, $company, $position, $suggestion)
    {
      if(User::where('email', '=', $email)->first() != null){
        return "User exist";
      }else{
        return User::create([
          'name' => $name,
          'loginotp' => $name,
          'password' => 'fintech',
          'email' => $email,
          'company' => $company,
          'position' => $position,
          'suggestion' => $suggestion,
          'imageurl' => 'https://visitorchat.myfintechweek.my/image/User.png',
          'booth' => $email,
          'role' => 'user'
        ]);
      }
    }

    public function listuser()
    {
      $authusername = Auth::user()->loginotp;
      $user = User::orderBy('updated_at', 'DESC')->where('loginotp', '!=', $authusername)->where('role', '=', 'user')->get();
      // $user = $authusername;
      return $user;

      // $user = User::orderBy('id')->paginate(10);
      // return response()->json([$user]);
    }

    public function updateuser($email, $loginotp)
    {
     DB::table('users')
        ->where('email', $email)  // find your user by their email
        ->limit(1)  // optional - to ensure only two record is updated.
        ->update(array('loginotp' => $loginotp));  // update the record in the DB. 
    }

    public function listexhibitor()
    {
      $authusername = Auth::user()->loginotp;
      $user = User::orderBy('updated_at', 'DESC')->where('loginotp', '!=', $authusername)->where('role', '=', 'operator')->get();
      // $user = $authusername;
      return $user;
    }

    public function listsuggestion()
    {
      $authusername = Auth::user()->loginotp;
      $authusersuggestion = Auth::user()->suggestion;
      $authusersuggestionarr = explode(',',$authusersuggestion);
      foreach($authusersuggestionarr as $authusersuggestionarrs){
        $user = User::orderBy('updated_at', 'DESC')->where('loginotp', '!=', $authusername)->where('role', '=', 'operator')->whereRaw("find_in_set('$authusersuggestionarrs',suggestion)")->orWhere('suggestion', 'LIKE', '%'.'Other'.'%')->get();
        return $user;
      }
      
      // $user = User::orderBy('updated_at', 'DESC')->where('loginotp', '!=', $authusername)->where('role', '=', 'operator')->whereRaw("find_in_set('$authusersuggestion',suggestion)")->get();
    
      // $user = $authusername;
      // dd($user);
    }

    public function touchuser($email){
      $finduserid = User::where('email', '=', $email)->value('id');
      $user = User::find($finduserid);
      if($user != null){
        $user->touch();
      }else{
        return 'no user to touch';
      }
      
    }

    public function export(){
      return Excel::download(new UsersExport, 'users.xlsx');
    }


}
?>