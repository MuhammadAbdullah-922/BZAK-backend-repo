<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        $token = $user->createToken('bzack_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('bzack_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    // Get Profile
    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'user'    => $request->user(),
        ]);
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
    $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email,' . $request->user()->id,
    'phone' => 'nullable|string|max:20',
    'address' => 'nullable|string|max:255',
    'city' => 'nullable|string|max:255',
]);
        $user = $request->user();

$user->update([
    'name'    => $request->name,
    'email'   => $request->email,
    'phone'   => $request->phone,
    'address' => $request->address,
    'city'    => $request->city,
]);
return response()->json([
    'success' => true,
    'message' => 'Profile updated successfully',
    'user' => $user,
]);
    }

    // Change Password (logged-in user)
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully',
        ]);
    }
// Upload / Update Avatar
public function uploadAvatar(Request $request)
{
    $request->validate([
        'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072', // 3MB
    ]);

    $user = $request->user();

    // purani avatar delete kar do (agar thi)
    if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
        \Storage::disk('public')->delete($user->avatar);
    }

    $path = $request->file('avatar')->store('avatars', 'public');

    $user->update(['avatar' => $path]);

    return response()->json([
        'success'    => true,
        'message'    => 'Profile picture updated successfully',
        'avatar_url' => asset('storage/' . $path),
    ]);
}
    // ================================
    // Forgot Password — Send Reset Link
    // ================================
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Laravel ka built-in password broker email bhejta hai
        // jisme token + link hota hai (config/auth.php ke "passwords" broker se)
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent to your email',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to send reset link. Please check the email address.',
        ], 422);
    }

    // ================================
    // Reset Password — Set New Password
    // ================================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Password has been reset successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired reset token',
        ], 422);
    }
}