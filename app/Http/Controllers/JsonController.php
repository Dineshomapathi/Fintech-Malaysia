<?php
 
namespace App\Http\Controllers;
use Redirect,Response;
use Illuminate\Http\Request;
use App\User;
 
class JsonController extends Controller
{

  public function store(Request $request)
  {
    // Read File

    $jsonString = file_get_contents(base_path('resources/json/registers.json'));

    // $data = json_decode($jsonString, true);;

    // foreach ($data['name'] as $i => $v){
    //     dd($v['area']);
    // }

    $user = json_decode($jsonString, true);

    foreach($user['user'] as $i => $v)
    {
        $data = array(
            'loginotp' => $v['name'],
            'password' => 'pga',
            'email' => $v['email'],
            'company' => $v['company'],
            'booth' => $v['email'],
            'role' => 'user'
        );
        User::create($data);  
    }

    // Get Key Value

    // dd($data);
    // dd($data['name']);
  }
 
}