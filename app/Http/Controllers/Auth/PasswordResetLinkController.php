<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);
            $firebaseAuth->sendPasswordResetLink($request->email);
            
            return back()->with('status', 'Te hemos enviado el enlace para restablecer tu contraseña al correo.');
        } catch (\Exception $e) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'No pudimos procesar tu solicitud: ' . $e->getMessage()]);
        }
    }
}
