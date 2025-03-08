<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function showRegister()
    {
        return view('admin.register');
    }

    public function showForgetPassword()
    {
        return view('auth.forget-password');
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? view('auth.password-email')->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            // Ambil user dan pastikan mereka tetap harus verifikasi email sebelum login
            $user = User::where('email', $request->email)->first();
            if ($user && $user->email_verified_at === null) {
                // Kirim ulang email verifikasi
                $user->sendEmailVerificationNotification();
                // Login user setelah register
                Auth::login($user);
                // Redirect ke halaman verifikasi
                return redirect()->route('verification.notice')
                    ->with('success', 'Silakan Periksa Email untuk verifikasi akun, supaya dapat segera digunakan');
            }
            return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            $request->session()->regenerate();

            if ($user->email_verified_at === null) {
                Auth::logout();
                $user->sendEmailVerificationNotification();
                // Login user setelah register
                Auth::login($user);
                // Redirect ke halaman verifikasi
                return redirect()->route('verification.notice')
                    ->with('success', 'Silakan Periksa Email untuk verifikasi akun, supaya dapat segera digunakan');
            }
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan tidak valid.',
        ])->withInput($request->except('password'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        // Debugging untuk melihat input yang diterima
        $fullName = trim($request->firstName) . ' ' . trim($request->lastName);

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
        }

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        // Login user setelah register
        Auth::login($user);

        // Redirect ke halaman verifikasi
        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi akun. Setelah verifikasi, Anda akan dapat login ke sistem.');
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
