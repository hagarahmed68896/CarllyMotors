<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth as LaravelAuth;

class AuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct(Auth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function verifyToken(Request $request)
    {
        $idTokenString = $request->token;

        try {
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->claims()->get('sub');
            $user = User::firstOrCreate(['firebase_uid' => $uid], [
                'name' => 'Firebase User',
                'email' => $uid . '@firebase.com',
                'password' => bcrypt('random_password')
            ]);

            LaravelAuth::login($user);

            return response()->json(['success' => true, 'redirect' => route('dashboard')]);

        } catch (FailedToVerifyToken $e) {
            return response()->json(['success' => false, 'error' => 'Invalid Token']);
        }
    }

    public function phone_check(Request $request){
        dd($request->query('phone'));

    }   
}
