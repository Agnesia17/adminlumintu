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
    # menampilkan halaman login
    public function showLogin()
    {
        return view('admin.login');
    }
    # menampilkan halaman register
    public function showRegister()
    {
        return view('admin.register');
    }
    # menampilkan halaman lupa password
    public function showForgetPassword()
    {
        return view('auth.forget-password');
    }
    # menampilkan halaman reset password dengan data token berdasarkan email user
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }
    # mengirim url link untuk reset password
    public function sendResetLink(Request $request)
    {
        # validasi email apakah sesuai
        $request->validate(['email' => 'required|email']);

        # mengirim url reset link password
        $status = Password::sendResetLink(
            $request->only('email')
        );

        # jika sukses route ke menu reset password
        return $status === Password::RESET_LINK_SENT
            ? view('auth.password-email')->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    # fungsi untuk reset password
    public function resetPassword(Request $request)
    {
        # validasi apakah data yang diperlukan sesuai
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
        # kembali ke menu sebelumnya karena error
        return back()->withErrors(['email' => __($status)]);
    }

    // fungsi untuk login
    public function login(Request $request)
    {
        // cek apakah data yang dimasukkan sesuai
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // jika data akun yang dimasukan benar maka data user ditemukan
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // membuat autentikasi user dan generate session
            $user = Auth::user();
            $request->session()->regenerate();

            // jika email user belum terverifikasi maka kirim email
            if ($user->email_verified_at === null) {
                Auth::logout();
                $user->sendEmailVerificationNotification();
                // Login user setelah register
                Auth::login($user);
                // Redirect ke halaman verifikasi
                return redirect()->route('verification.notice')
                    ->with('success', 'Silakan Periksa Email untuk verifikasi akun, supaya dapat segera digunakan');
            }
            // jika sudah maka diarahkan ke halaman dashbord
            return redirect()->intended('/dashboard');
        }
        // jika gagal tetap dihalaman login
        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan tidak valid.',
        ])->withInput($request->except('password'));
    }

    // fungsi untuk register
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

    // fungsi untun logout
    public function logout(Request $request)
    {
        // AUTENTIKASI DATA DIHAPUS  dan session dihapus kemudian menuju halaman login
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
