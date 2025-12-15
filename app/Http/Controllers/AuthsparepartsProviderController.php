<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\allUsersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use App\Models\Image;
class AuthsparepartsProviderController extends Controller
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
        $companyName = $request->input('company_name');


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
                    'userType' => 'shop_dealer',
                ]
            );
            // Create dealer profile only once
            if (!$user->dealer) {
                $user->dealer()->create([
                    'company_name'    => $companyName,
                    'company_address' => '',
                    'company_img'     => 'icon/notfound.png',
                ]);
            }

            Auth::login($user);
            return response()->json(['success' => true, 'redirect' => route('spareparts.dashboard')]);
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
                'userType' => 'shop_dealer',
            ]
        );
        // Create dealer profile only once
        if (!$user->dealer) {
            $user->dealer()->create([
                'company_name'    => $companyName,
                'company_address' => '',
                'company_img'     => 'icon/notfound.png',
            ]);
        }

        Auth::login($user);
        return response()->json(['success' => true, 'redirect' => route('spareparts.dashboard')]);

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
        $users = allUsersModel::where('usertype', 'shop_dealer')
            ->whereNotNull('phone')
            ->get();

        // ===== مطابقة الرقم بعد تنظيفه في PHP =====
        $user = $users->first(function ($u) use ($cleanPhone) {
            $dbPhone = preg_replace('/\D/', '', $u->phone);
            return $dbPhone === $cleanPhone;
        });

        if (!$user) {
            return response()->json(['success'=>false,'error'=>'Phone not registered as spareparts dealer'], 404);
        }

        // ===== تسجيل الدخول =====
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return response()->json(['success'=>true,'redirect'=>route('spareparts.dashboard')]);

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

        return redirect()->route('providers.spareparts.login');
    }


      public function profile($id)
    {
        if ($id == auth()->user()->id) {
            $user = allUsersModel::find($id);
            return view('providers.spareParts.profile', compact('user'));
        } else {
            return redirect()->route('providers.spareparts.login');
        }

    }


public function update(Request $request, $id)
{
    try {
        if ($id != auth()->user()->id) {
            return redirect()->route('providers.spareparts.login');
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
        if ($user->dealer) {
            $user->dealer->update([
                'company_name'    => $request->company_name ?? $user->dealer->company_name,
                'company_address' => $request->location,
            ]);
        } else {
            $user->dealer()->create([
                'company_name'    => $request->company_name,
                'company_address' => $request->location,
                'company_img'     => 'icon/notfound.png',
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

            if (!file_exists(public_path('dealers'))) {
                mkdir(public_path('dealers'), 0755, true);
            }

            $file->move(public_path('dealers'), $filename);

            $user->update(['image' => 'dealers/' . $filename]);
        }

        return redirect()->route('spareparts.dashboard')->with('success', 'Profile updated successfully!');

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

            if ($user->dealer && $user->dealer->company_img && file_exists(public_path($user->dealer->company_img))) {
                unlink(public_path($user->dealer->company_img));
                $user->dealer->update(['company_img' => null]);
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

        if ($user->dealer && $user->dealer->company_img && file_exists(public_path($user->dealer->company_img))) {
            unlink(public_path($user->dealer->company_img));
        }

        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        if (!file_exists(public_path('dealers'))) {
            mkdir(public_path('dealers'), 0755, true);
        }

        $file->move(public_path('dealers'), $filename);

        $path = 'dealers/' . $filename;

        $user->update(['image' => $path]);

        if ($user->dealer) {
            $user->dealer->update(['company_img' => $path]);
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
    // 1. Ensure the authenticated user is the one they are trying to delete
    if ($id != auth()->user()->id) {
        // You might redirect with an error message or throw an unauthorized exception
        return redirect()->route('spareparts.dashboard')->with('error', 'Unauthorized action.');
    }

    $user = allUsersModel::find($id);

    if (!$user) {
        return redirect()->route('spareparts.dashboard')->with('error', 'User not found.');
    }

    // 2. Perform the deletion
    $user->delete();

    // 3. Log the user out after deletion
    auth()->logout();

    // 4. Redirect to the homepage or login page with a success message
    return redirect('/')->with('success', 'Your profile has been successfully deleted.');
}
}
