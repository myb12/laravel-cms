<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view( 'home' );
    }

    public function shoutHome() {
        $userId = Auth::id();
        if(Friend::where('user_id',$userId)->where('friend_id',$userId)->count()==0){
            $friendship = new Friend();
            $friendship->user_id = $userId;
            $friendship->friend_id = $userId;
            $friendship->save();
        }
        $friendId = Friend::select('friend_id')->where('user_id', $userId)->get();
        $status = Auth::user()->friendsStatus;
        //$status = Status::where('user_id', $userId)->orderBy('id','desc')->get();
        // $avatar = empty(Auth::user()->avatar) ? asset('images/avatar.jpg') : Auth::user()->avatar;
        $avatar = User::select('avatar')->where('id', $friendId)->get();


        return view("shouthome",array('status'=>$status,'avatar'=>$avatar)
        ); 
    }

    public function publicTimeline($nickname){
        $user = User::where('nickname', $nickname)->first();
        if ($user) {
            $status = Status::where('user_id', $user->id)->orderBy('id','desc')->get();
            $avatar = empty($user->avatar) ? asset('images/avatar.jpg') : $user->avatar; 
            $name = $user->name;

            $displayActions = false;

        if ( Auth::check() ) {
                 if ( Auth::user()->id != $user->id ) {
                     $displayActions = true;
                 }
             }
            return view("shoutpublic",array('status'=>$status,
                'avatar'=>$avatar,
                'name'=>$name, 
                'displayActions' => $displayActions,
                'friendId' => $user->id,));
        }else{
            return redirect('shout');
        }
    }

    public function saveStatus( Request $request ) {
        if ( Auth::check() ){

            $status = $request->post( 'status' );
            $userId = Auth::id();

            $statusModel = new Status();
            $statusModel->status = $status;
            $statusModel->user_id = $userId;
            $statusModel->save();
            return redirect()->route('shout');
        }
    }

    function saveProfile(Request $request){

        if (Auth::check()) {

             $userModel = Auth::user(); //taking model of currently logged in user
             $userModel->name = $request->post( 'name' );
             $userModel->email = $request->post( 'email' );
             $userModel->nickname = $request->post( 'nickname' );

             $profileImage = 'user' . $userModel->id . '.' . $request->image->extension();
             $request->image->move(public_path('images'),$profileImage);

             $userModel->avatar = asset( "images/{$profileImage}" );
             $userModel->save();
             return redirect()->route('shout.profile');
        }
    }

    public function profile() {

        return view( 'profile' );
    }

    public function makeFriend($friendId){
        $userId = Auth::user()->id;

        if(Friend::where('user_id',$userId)->where('friend_id',$friendId)->count()==0){

        $friendship = new Friend();
        $friendship->user_id = $userId;
        $friendship->friend_id = $friendId;
        $friendship->save();
        }
        
        if(Friend::where('user_id',$friendId)->where('friend_id',$userId)->count()==0){
        $friendship = new Friend();
        $friendship->user_id = $friendId;
        $friendship->friend_id = $userId; 
        $friendship->save();
        }

        return redirect('shout');
    }

    public function unFriend($friendId){
        $userId = Auth::user()->id;

        Friend::where('user_id',$userId)->where('friend_id',$friendId)->delete();
        Friend::where('user_id',$friendId)->where('friend_id',$userId)->delete();
        return redirect('shout');
    }
}
