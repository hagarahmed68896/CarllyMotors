<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use App\Models\allUsersModel;
use Illuminate\Support\Facades\Auth as LaravelAuth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;

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
    $idTokenString = $request->token;

    try {
        // Verify Firebase token
        $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idTokenString);
        $uid = $verifiedIdToken->claims()->get('sub');

        // Find or create the user
        $user = allUsersModel::firstOrCreate(
            ['firebase_uid' => $uid], // Search by Firebase UID
            [
                'fname' => 'Firebase User',
                'email' => $uid . '@firebase.com', // Dummy email (Firebase doesn’t provide an email for phone auth)
                'password' => bcrypt('random_password') // Not used but required in Laravel
            ]
        );

        // Log in the user
        Auth::login($user);

        return response()->json([
            'success' => true,
            'uid' => $uid,
            'redirect' => route('dashboard')
        ]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
    }
}

    public function phone_check(Request $request){
        dd($request->query('phone'));

    }   
}
