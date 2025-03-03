<?php
namespace App\Http\Controllers;

use App\Models\allUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

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
            $uid = $verifiedIdToken->claims()->get('sub'); // Get Firebase UID

            // Find the user in the database
            $user = allUsersModel::where('firebase_uid', $uid)->first();

            if (!$user) {
                // Create a new user if not found
                $user = new allUsersModel();
                $user->fname = 'Firebase User';
                $user->email = $uid . '@firebase.com';
                $user->password = bcrypt('12345678'); // Temporary password
                $user->firebase_uid = $uid;
                $user->userType = 'user';
                $user->save();
            }

            // Double-check if user is saved
            $user = allUsersModel::where('firebase_uid', $uid)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User was not created in the database!'
                ]);
            }

            // Authenticate the user
            Auth::guard('web')->login($user);

            // Check if authentication is successful
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'User authentication failed!',
                ]);
            }

            return response()->json([
                'success' => true,
                'uid' => $uid,
                'redirect' => route('home'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 401);
        }
    }
}
