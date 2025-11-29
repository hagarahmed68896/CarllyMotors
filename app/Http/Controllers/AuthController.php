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
                    'userType' => 'user',
                ]
            );

            Auth::login($user);
            return response()->json(['success' => true, 'redirect' => route('home')]);
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
                'userType' => 'user',
            ]
        );

        Auth::login($user);
        return response()->json(['success' => true, 'redirect' => route('home')]);

    } catch (\Throwable $e) {
        \Log::error('Firebase verify error: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
    }
}



public function verifyLoginToken(Request $request)
{
    try {
        $frontendPhone = $request->input('phone');

        // ===== تنظيف الرقم =====
        $cleanPhone = preg_replace('/\D/', '', $frontendPhone); // فقط الأرقام
        if (!$cleanPhone) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid phone number'
            ], 422);
        }

        // ===== جلب كل الـ users مع رقم موجود =====
        $users = allUsersModel::where('usertype', 'user')
            ->whereNotNull('phone')
            ->get();

        // ===== مطابقة الرقم بعد تنظيفه في PHP =====
        $user = $users->first(function ($u) use ($cleanPhone) {
            $dbPhone = preg_replace('/\D/', '', $u->phone);
            return $dbPhone === $cleanPhone;
        });

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Phone not registered as user'
            ], 404);
        }

        // ===== تسجيل الدخول =====
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'redirect' => route('home')
        ]);

    } catch (\Throwable $e) {
        \Log::error("User login verify error: ".$e->getMessage());
        return response()->json([
            'success' => false,
            'error' => 'Unexpected server error'
        ], 500);
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
        // ✅ السماح فقط للمستخدم بتحديث بروفايله
        if ($id != auth()->user()->id) {
            return redirect()->route('home');
        }

        $user = allUsersModel::findOrFail($id);

        // تجهيز رقم الهاتف
        $rawPhone = preg_replace('/\s+/', '', $request->phone);
        $rawPhone = ltrim($rawPhone, '0');
        if (!str_starts_with($rawPhone, '+971')) {
            $rawPhone = '+971' . $rawPhone;
        }

        // تحديث البيانات النصية
        $user->fname    = $request->fname;
        $user->lname    = $request->lname;
        $user->phone    = $rawPhone;
        $user->email    = $request->email;
        $user->city     = $request->city;
        $user->location = $request->location;
        $user->lat      = $request->latitude;
        $user->lng      = $request->longitude;

        $user->save();

        // رفع صورة البروفايل
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // إنشاء مجلد users إذا لم يكن موجود
            if (!file_exists(public_path('users'))) {
                mkdir(public_path('users'), 0755, true);
            }

            // نقل الصورة مباشرة إلى public/users
            $file->move(public_path('users'), $filename);

            // حفظ المسار في قاعدة البيانات
            $user->image = 'users/' . $filename;
            $user->save();
        }

return redirect()->route('home')->with('success', 'Profile updated successfully!');

        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}

public function updateImage(Request $request, $id)
{
    try {
        // حماية
        if ($id != auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = allUsersModel::findOrFail($id);

        // إذا طلب حذف الصورة
        if ($request->remove_image == 1) {

            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $user->image = null;
            $user->save();

            return response()->json([
                'success' => true,
                'image' => asset('user-201.png'),
            ]);
        }

        // لو مفيش صورة مرفوعة ومفيش حذف → خطأ
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image uploaded'], 400);
        }

        // حذف القديمة
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        // حفظ الجديدة
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        if (!file_exists(public_path('users'))) {
            mkdir(public_path('users'), 0755, true);
        }

        $file->move(public_path('users'), $filename);

        $user->image = 'users/' . $filename;
        $user->save();

        return response()->json([
            'success' => true,
            'image' => asset($user->image),
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
        return redirect()->route('home')->with('error', 'Unauthorized action.');
    }

    $user = allUsersModel::find($id);

    if (!$user) {
        return redirect()->route('home')->with('error', 'User not found.');
    }

    // 2. Perform the deletion
    $user->delete();

    // 3. Log the user out after deletion
    auth()->logout();

    // 4. Redirect to the homepage or login page with a success message
    return redirect('/')->with('success', 'Your profile has been successfully deleted.');
}






    
}
