<?php

namespace App\Http\Controllers\API\V1;

use App\Book;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        $user = Auth::attempt($credentials);
        if ($user) {
            return response()->json(Auth::user());
        } else {
            return response()->json('unexpected error please try later');
        }
    }

    public function logout(Request $request)
    {

        Auth::logout();
        return response()->json('logout done');
    }

    public function register(Request $request)
    {
            $user = new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->api_token=Str::random(80);
            $user->save();
        $profile = new Profile();

        $profile->user_id = $user->id;
        $profile->fcm_token = $request->fcm_token;
        $profile->save();
        return response()->json($user);
    }

    public function getAllUsers()
    {
        $users = User::with('profile')->get()->except(Auth::id());
        return response()->json($users);
    }

    public static function notifyUser($book)
    {

        $user_token = Profile::get()->except(Auth::id());
     $tokens=[];
     foreach ($user_token as $profile){
         array_push($tokens,$profile->fcm_token);
     }
//          $getTokenOwnerData = Profile::where('fcm_token', $book)->with('user')->first();

        $SERVER_API_KEY = 'AAAAbPgDazc:APA91bFSRgAe8O8pDZ8JGgsprQt6mVTlVj_HiKMnwTHzc4tLDRXpegVyKMfAgv14sc6ClWi9WpMjIGlLTuXF65IlV3jtdSPNmJ3PMpeqmE8uNTDBYqypN2La7U8ovdQW1LBl2KtvA9NK';
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                //"title" => "Dear ".$getTokenOwnerData->user->name." Attention",
                //"body" => Auth::user()->name." Visited Your Profile",
                "sound" => true,
                // 'image' => $request->image_url
                "title" => "Dear User  Check Our New Book",
                "body" => "A " . $book->name . "With Just Only " . $book->price . " $, Be Our First Buyer.",
            ],
            "data" => [
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ],
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',
        ];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);

        return response()->json('All Users Were Notified.');
    }
}

