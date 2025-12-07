<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\allUsersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use App\Models\Image;

class AuthWorkshopProviderController extends Controller
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
        $workshopName = $request->input('workshop_name');


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
                    'userType' => 'workshop_provider',
                ]
            );
            // Create workshop profile only once
            if (!$user->workshop_provider) {
                $user->workshop_provider()->create([
                    'workshop_name'    => $workshopName,
                    'address' => '',
                    'workshop_logo'     => 'icon/notfound.png',
                    'owner' => $fname . ' ' . $lname,
                ]);
            }

            Auth::login($user);
            return response()->json(['success' => true, 'redirect' => route('workshops.dashboard')]);
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
                'userType' => 'workshop_provider',
            ]
        );
        // Create workshop profile only once
        if (!$user->workshop_provider) {
            $user->workshop_provider()->create([
                'workshop_name'    => $workshopName,
                'address' => '',
                'workshop_logo'     => 'icon/notfound.png',
                'owner' => $fname . ' ' . $lname,
            ]);
        }

        Auth::login($user);
        return response()->json(['success' => true, 'redirect' => route('workshops.dashboard')]);

    } catch (\Throwable $e) {
        \Log::error('Firebase verify error: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
    }
}

public function verifyWorkshopLoginToken(Request $request)
{
    try {
        $idToken = $request->input('token');
        $frontendPhone = $request->input('phone');

        // ===== تنظيف الرقم =====
        $cleanPhone = preg_replace('/\D/', '', $frontendPhone); // فقط الأرقام
        if (!$cleanPhone) {
            return response()->json(['success'=>false,'error'=>'Invalid phone number'], 422);
        }

        // ===== جلب كل الـ workshops مع رقم موجود =====
        $users = allUsersModel::where('usertype', 'workshop_provider')
            ->whereNotNull('phone')
            ->get();

        // ===== مطابقة الرقم بعد تنظيفه في PHP =====
        $user = $users->first(function ($u) use ($cleanPhone) {
            $dbPhone = preg_replace('/\D/', '', $u->phone);
            return $dbPhone === $cleanPhone;
        });

        if (!$user) {
            return response()->json(['success'=>false,'error'=>'Phone not registered '], 404);
        }

        // ===== تسجيل الدخول =====
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return response()->json(['success'=>true,'redirect'=>route('workshops.dashboard')]);

    } catch (\Throwable $e) {
        \Log::error("Firebase login verify error: ".$e->getMessage());
        return response()->json(['success'=>false,'error'=>'Unexpected server error'], 500);
    }
}

public function login()
{
    // لو أي يوزر مسجل دخول
    if (auth()->check()) {

        // جلب نوع اليوزر من جدول allusers
        $user = auth()->user(); // أو حسب الـ model اللي مربوط بالجدول allusers
        $userType = $user->usertype; // افترضنا إن العمود اسمه 'usertype'

        if ($userType === 'workshop_provider') {
            // لو اليوزر provider → روح للـ dashboard الخاص بالـ provider
            return redirect()->route('workshops.dashboard');
        } else {
            // لو user من نوع مختلف → اعمل logout
            auth()->logout();
            session()->flush();
            return redirect()->route('providers.workshops.login'); // صفحة login للـ provider
        }
    }

    // لو مش مسجل دخول → عرض صفحة login للـ provider
    return view('providers.workshops.login');
}

// ===== Logout =====
public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('providers.workshops.login');
    }


      public function profile($id)
    {
        if ($id == auth()->user()->id) {
            $user = allUsersModel::find($id);
            return view('providers.workshops.profile', compact('user'));
        } else {
            return redirect()->route('providers.workshops.login');
        }

    }


public function update(Request $request, $id)
{
    try {
        if ($id != auth()->user()->id) {
            return redirect()->route('providers.workshops.login');
        }

        $user = allUsersModel::findOrFail($id);

        // تجهيز رقم الهاتف
        $rawPhone = preg_replace('/\s+/', '', $request->phone);
        $rawPhone = ltrim($rawPhone, '0');
        if (!str_starts_with($rawPhone, '+971')) {
            $rawPhone = '+971' . $rawPhone;
        }

        // ================= تحديث بيانات اليوزر =================
        $user->update([
            'fname'    => $request->fname,
            'lname'    => $request->lname,
            'phone'    => $rawPhone,
            'email'    => $request->email,
            'city'     => $request->city,
            'location' => $request->location,
            'lat'      => $request->latitude,
            'lng'      => $request->longitude,
        ]); 

        // ================= تحديث بيانات الديلر =================
        if ($user->workshop_provider) {
            $user->workshop_provider->update([
                'workshop_name'    => $request->workshop_name ?? $user->workshop_provider->workshop_name,
                'address' => $request->location,
            ]);
        } else {
            $user->workshop_provider()->create([
                'workshop_name'    => $request->workshop_name,
                'address' => $request->location,
                'workshop_logo'     => 'icon/notfound.png',
            ]);
        }

        // ================= رفع صورة المستخدم =================
        if ($request->hasFile('image')) {

            // حذف القديمة
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $file = $request->file('image');
            $filename = 'user_' . time() . '.' . $file->getClientOriginalExtension();

            if (!file_exists(public_path('workshops'))) {
                mkdir(public_path('workshops'), 0755, true);
            }

            $file->move(public_path('workshops'), $filename);

            $user->update(['image' => 'workshops/' . $filename]);
        }

        return redirect()->route('workshops.dashboard')->with('success', 'Profile updated successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}



public function updateImage(Request $request, $id)
{
    try {
        if ($id != auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = allUsersModel::findOrFail($id);

        // ========== حذف الصورة ==========
        if ($request->remove_image == 1) {

            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $user->update(['image' => null]);

            if ($user->workshop_provider && $user->workshop_provider->workshop_logo && file_exists(public_path($user->workshop_provider->workshop_logo))) {
                unlink(public_path($user->workshop_provider->workshop_logo));
                $user->workshop_provider()->update(['workshop_logo' => null]);
            }

            return response()->json([
                'success' => true,
                'image' => asset('user-201.png'),
            ]);
        }

        // ========== رفع الصورة ==========
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image uploaded'], 400);
        }

        // حذف القديمة
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        if ($user->workshop_provider && $user->workshop_provider->workshop_logo && file_exists(public_path($user->workshop_provider->workshop_logo))) {
            unlink(public_path($user->workshop_provider->workshop_logo));
        }

        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        if (!file_exists(public_path('workshops'))) {
            mkdir(public_path('workshops'), 0755, true);
        }

        $file->move(public_path('workshops'), $filename);

        $path = 'workshops/' . $filename;

        $user->update(['image' => $path]);

        if ($user->workshop_provider) {
            $user->workshop_provider->update(['workshop_logo' => $path]);
        }

        return response()->json([
            'success' => true,
            'image' => asset($path),
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}




public function deleteProfile($id)
{
    // Ensure the authenticated user is the one deleting the profile
    if ($id != auth()->user()->id) {
        return redirect()->route('workshops.dashboard')
            ->with('error', 'Unauthorized action.');
    }

    $user = allUsersModel::find($id);

    if (!$user) {
        return redirect()->route('workshops.dashboard')
            ->with('error', 'User not found.');
    }

    // ================================
    // DELETE RELATED WORKSHOP PROVIDER
    // ================================
    if ($user->workshop_provider) {

        // Delete workshop image if exists
        if ($user->workshop_provider->workshop_logo &&
            file_exists(public_path($user->workshop_provider->workshop_logo))) {

            unlink(public_path($user->workshop_provider->workshop_logo));
        }

        // Delete the workshop provider row
        $user->workshop_provider()->delete();
    }

    // ================================
    // DELETE USER IMAGE
    // ================================
    if ($user->image && file_exists(public_path($user->image))) {
        unlink(public_path($user->image));
    }

    // ================================
    // DELETE USER
    // ================================
    $user->delete();

    // ================================
    // LOGOUT
    // ================================
    auth()->logout();

    return redirect('/')
        ->with('success', 'Your profile has been successfully deleted.');
}

}
