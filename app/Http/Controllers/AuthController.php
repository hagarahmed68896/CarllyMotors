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
            $uid             = $verifiedIdToken->claims()->get('sub'); // Get Firebase UID

            // Find the user in the database
            $user = allUsersModel::where('firebase_uid', $uid)->first();

            if (! $user) {
                // Create a new user if not found
                $user               = new allUsersModel();
                $user->fname        = 'User';
                $user->email        = 'user@firebase.com';
                $user->password     = bcrypt('123456'); // Temporary password
                $user->firebase_uid = $uid;
                $user->userType     = 'user';
                $user->save();
            }

            // Double-check if user is saved
            $user = allUsersModel::where('firebase_uid', $uid)->first();
            if (! $user) {
                return response()->json([
                    'success' => false,
                    'error'   => 'User was not created in the database!',
                ]);
            }

            // Authenticate the user
            Auth::guard('web')->login($user);

            // Check if authentication is successful
            if (! Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error'   => 'User authentication failed!',
                ]);
            }

            return response()->json([
                'success'  => true,
                'uid'      => $uid,
                'redirect' => route('home'),
            ]);

        } catch (\Exception $e) {
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
