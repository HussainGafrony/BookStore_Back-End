<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(80),
        ]);
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

    public function notifyUser($userToken)
    {
        $getTokenOwnerData = Profile::where('fcm_token', $userToken)->with('user')->first();

        $SERVER_API_KEY = 'AAAAbPgDazc:APA91bFSRgAe8O8pDZ8JGgsprQt6mVTlVj_HiKMnwTHzc4tLDRXpegVyKMfAgv14sc6ClWi9WpMjIGlLTuXF65IlV3jtdSPNmJ3PMpeqmE8uNTDBYqypN2La7U8ovdQW1LBl2KtvA9NK';

        $data = [
            "registration_ids" => [$userToken],
          "notification" => [
              "title" => "Dear ".$getTokenOwnerData->user->name." Attention",
              "body" => Auth::user()->name."Visited Your Profile",
              // "sound"=>true,

              // 'image' => $request->image_url
          ],
            "data" => [
                'click_action'=> 'FLUTTER_NOTIFICATION_CLICK',
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

        return response()->json(1);
    }
}
