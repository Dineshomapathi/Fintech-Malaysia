<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    public function get(Request $request)
    {
        // User role
        $role = Auth::user()->role; 
        $booth = $request->session()->get('booth');
        $auth = auth()->id();

        // get all users except the authenticated one
        switch ($role) {
            case 'operator':
                //$contacts = User::where('id', '!=', auth()->id())->where('role', '=', 'user')->get();
                $contacts = DB::table('users')
                            ->whereIn('id', function($query){
                                $query
                                ->select(DB::raw('users.id from users'))
                                ->distinct()
                                ->leftJoin('messages', function($join){
                                $join->on('users.id', '=', 'messages.from');
                                })
                                ->whereNotNull('messages.from')
                                ->where('role','=','user')
                                // ->orWhere('role', '=', 'operator')
                                ->where('messages.to','=', auth()->id());
                            })
                            ->get();
                break;
            case 'user':
                // $contacts = User::where('id', '!=', auth()->id())->where('role', '=', 'user')->orderby('updated_at', 'asc')->get();
                $contacts = DB::table('users')
                            ->whereIn('id', function($query){
                                $query
                                ->select(DB::raw('users.id from users'))
                                ->distinct()
                                ->leftJoin('messages', function($join){
                                $join->on('users.id', '=', 'messages.from');
                                // $join->on('users.id', '=', 'messages.from')->orderby('created_at', 'desc');
                                })
                                ->whereNotNull('messages.from')
                                // ->whereNotNull('messages.from')
                                ->where('role','!=','moderator')
                                // ->orWhere('role', '=', 'user')
                                ->where('messages.to','=', auth()->id());
                            })
                            ->get();     

                break; 
        }         
       
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        // add an unread key to each contact with the count of unread messages
        // $contacts = $contacts->map(function($contact) use ($unreadIds) {
        //     $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

        //     $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

        //     return $contact;
        // });

        foreach ($contacts as $contact){
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            $fromToIds = [auth()->id(), $contact->id];
            $contact->last_message = Message::whereIn('from', $fromToIds)
            ->whereIn('to', $fromToIds)
            ->orderBy('created_at', 'desc')
            ->first()->created_at;
        }
        
        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
        ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text
        ]);

        $user = User::find(auth()->id());
        $user->touch();

        broadcast(new NewMessage($message));

        return response()->json($message);
    }


    public function notification($id)
    {
        $userid = User::where('loginotp', $id)->pluck('id')->first();
        $unread = Message::where('to', $userid)->where('read', '0')->count();
        return $unread;
    }

    public function listoperator()
    {
        $list = User::where('role', 'operator')->get();
        return $list;
    }

    public function addoperator($loginotp , $password, $lang, $project, $role, $booth, $welcometext, $company, $position, $suggestion, $image)
    {
        if($welcometext == 'empty'){
            $operator = User::create([
                'loginotp' => $loginotp,
                'password' => $password,
                'lang' => $lang,
                'project' => $project,
                'role' => $role,
                'booth' => $booth,
                'welcometext' => NULL,
                'company' => $company,
                'position' => $position,
                'suggestion' => $suggestion,
                'imageurl' => $image,
            ]);
        }else{
            $operator = User::create([
                'loginotp' => $loginotp,
                'password' => $password,
                'lang' => $lang,
                'project' => $project,
                'role' => $role,
                'booth' => $booth,
                'welcometext' => $welcometext,
                'company' => $company,
                'position' => $position,
                'suggestion' => $suggestion,
                'imageurl' => $image,
            ]);
        }

        
        return $operator;
    }

    public function updateoperator($loginotp , $password, $lang, $project, $role, $booth, $welcometext)
    {
        if($welcometext == 'empty'){
            $operator = User::where('loginotp', $loginotp)
            ->update([            
            'password' => $password,
            'lang' => $lang,
            'project' => $project,
            'role' => $role,
            'booth' => $booth,
            'welcometext' => NULL
            ]);
        }else{
            $operator = User::where('loginotp', $loginotp)
            ->update([            
            'password' => $password,
            'lang' => $lang,
            'project' => $project,
            'role' => $role,
            'booth' => $booth,
            'welcometext' => $welcometext
            ]);
        }

        return $operator;
    }

    public function deleteoperator($loginotp)
    {
        $operatorid = User::where('loginotp', $loginotp)->pluck('id')->first();
        $delete = User::where('id',$operatorid)->delete();
        return $delete;
    }

}
