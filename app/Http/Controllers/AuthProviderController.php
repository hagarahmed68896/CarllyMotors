<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\allUsersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
class AuthProviderController extends Controller
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
    try {
        $idTokenString = $request->input('token');

        // frontend data (مش مهمة لو Firebase موجود لكن لازم نخزنها)
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $frontendPhone = $request->input('phone');
        $frontendEmail = $request->input('email');

        // ========== DEBUG MODE ==========
        if ($idTokenString === 'FAKE_ID_TOKEN_FOR_DEV' || $request->boolean('debug')) {

            $uid = $request->input('uid') ?? 'DEBUG_UID_' . uniqid();

            // VALIDATION
            if ($frontendPhone && allUsersModel::where('phone', $frontendPhone)->exists()) {
                return response()->json(['success' => false, 'error' => 'Phone already exists'], 409);
            }
            if ($frontendEmail && allUsersModel::where('email', $frontendEmail)->exists()) {
                return response()->json(['success' => false, 'error' => 'Email already exists'], 409);
            }

            // CREATE / UPDATE
            $user = allUsersModel::updateOrCreate(
                ['firebase_uid' => $uid],
                [
                    'fname' => $fname,
                    'lname' => $lname,
                    'email' => $frontendEmail,
                    'phone' => $frontendPhone,
                    'password' => bcrypt('123456'),
                    'userType' => 'dealer',
                ]
            );

            Auth::login($user);
            return response()->json(['success' => true, 'redirect' => route('cars.dashboard')]);
        }

        // ========== REAL FIREBASE MODE ==========
        $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idTokenString);
        $uid = $verifiedIdToken->claims()->get('sub');
        $firebaseUser = $this->firebaseAuth->getUser($uid);

        // ناخد من الـ frontend أولاً
        $phone = $frontendPhone ?? $firebaseUser->phoneNumber ?? null;
        $email = $frontendEmail ?? $firebaseUser->email ?? null;

        // VALIDATION
        if ($phone && allUsersModel::where('phone', $phone)->where('firebase_uid', '!=', $uid)->exists()) {
            return response()->json(['success' => false, 'error' => 'Phone already exists'], 409);
        }
        if ($email && allUsersModel::where('email', $email)->where('firebase_uid', '!=', $uid)->exists()) {
            return response()->json(['success' => false, 'error' => 'Email already exists'], 409);
        }

        // CREATE / UPDATE
        $user = allUsersModel::updateOrCreate(
            ['firebase_uid' => $uid],
            [
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'phone' => $phone,
                'password' => bcrypt('123456'),
                'userType' => 'dealer',
            ]
        );

        Auth::login($user);
        return response()->json(['success' => true, 'redirect' => route('cars.dashboard')]);

    } catch (\Throwable $e) {
        \Log::error('Firebase verify error: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
    }
}
public function verifyCarsLoginToken(Request $request)
{
    try {
        $idToken = $request->input('token');
        $frontendPhone = $request->input('phone');

        // ===== تنظيف الرقم =====
        $cleanPhone = preg_replace('/\D/', '', $frontendPhone); // فقط الأرقام
        if (!$cleanPhone) {
            return response()->json(['success'=>false,'error'=>'Invalid phone number'], 422);
        }

        // ===== جلب كل الـ dealers مع رقم موجود =====
        $users = allUsersModel::where('usertype', 'dealer')
            ->whereNotNull('phone')
            ->get();

        // ===== مطابقة الرقم بعد تنظيفه في PHP =====
        $user = $users->first(function ($u) use ($cleanPhone) {
            $dbPhone = preg_replace('/\D/', '', $u->phone);
            return $dbPhone === $cleanPhone;
        });

        if (!$user) {
            return response()->json(['success'=>false,'error'=>'Phone not registered as dealer'], 404);
        }

        // ===== تسجيل الدخول =====
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return response()->json(['success'=>true,'redirect'=>route('cars.dashboard')]);

    } catch (\Throwable $e) {
        \Log::error("Firebase login verify error: ".$e->getMessage());
        return response()->json(['success'=>false,'error'=>'Unexpected server error'], 500);
    }
}

    // ===== Logout =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('providers.cars.login');
    }

}
