<?php
namespace App\Http\Controllers;

use App\Models\allUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\InvalidToken;


class AuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct()
    {
        $this->firebaseAuth = (new Factory)
            ->withServiceAccount(base_path('storage/app/firebase/firebase_credentials.json'))
            ->createAuth();
    }

public function verifyToken(Request $request)
{
    $idTokenString = $request->input('token'); // ✅ الأفضل استخدام input()

    try {
        // ===============================
        // 🔧 1️⃣ Debug mode (FAKE OTP)
        // ===============================
        if ($idTokenString === 'FAKE_ID_TOKEN_FOR_DEV') {

            $uid = 'DEBUG_UID';

            $user = allUsersModel::firstOrCreate(
                ['firebase_uid' => $uid],
                [
                    'fname'    => 'Debug User',
                    'email'    => 'debug@local.test',
                    'password' => bcrypt('123456'),
                    'userType' => 'user',
                ]
            );

            Auth::guard('web')->login($user);

            return response()->json([
                'success'  => true,
                'uid'      => $uid,
                'redirect' => route('home'),
                'note'     => '✅ Debug OTP accepted successfully',
            ]);
        }

        // ===============================
        // 🔒 2️⃣ Real Firebase token
        // ===============================
        if (empty($idTokenString)) {
            throw new \Exception('Missing ID Token in request');
        }

        $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idTokenString);
        $uid = $verifiedIdToken->claims()->get('sub');

        $user = allUsersModel::firstOrCreate(
            ['firebase_uid' => $uid],
            [
                'fname'    => 'User',
                'email'    => 'user@firebase.com',
                'password' => bcrypt('123456'),
                'userType' => 'user',
            ]
        );

        Auth::guard('web')->login($user);

        return response()->json([
            'success'  => true,
            'uid'      => $uid,
            'redirect' => route('home'),
        ]);

    } catch (\Kreait\Firebase\Exception\Auth\InvalidToken $e) {
        Log::error('❌ Invalid Firebase Token: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error'   => 'Invalid Firebase Token: ' . $e->getMessage(),
        ], 401);

    } catch (\Throwable $e) {
        Log::error('❌ Firebase Verify Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error'   => $e->getMessage(),
        ], 401);
    }
}



    public function profile($id)
    {
        if ($id == auth()->user()->id) {
            $user = allUsersModel::find($id);
            return view('auth.profile', compact('user'));
        } else {
            return redirect()->route('home');
        }

    }

    public function edit($id)
    {
        if ($id == auth()->user()->id) {
            // dd($id);
            $user = allUsersModel::find($id);
            // dd($user);
            return view('auth.edit', compact('user'));
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if ($id == auth()->user()->id) {
                $user           = allUsersModel::find($id);
                $user->fname    = $request->fname;
                $user->lname    = $request->lname;
                $user->phone    = $request->phone;
                $user->email    = $request->email;
                $user->city     = $request->city;
                $user->location = $request->location;
                $user->lat      = $request->latitude;
                $user->lng      = $request->longitude;
                $user->save();
                if ($request->hasFile('image')) {
                
                    if(count($user->getMedia('profile')) == 0){
                        $user->addMedia($request->file('image'))->toMediaCollection('profile');
                    }else{
                        $user->getMedia('profile')[0]->delete();
                        $user->addMedia($request->file('image'))->toMediaCollection('profile');
                    }
                }
                return redirect()->route('profile', $id);
            } else {
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
