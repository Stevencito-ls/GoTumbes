<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Kreait\Firebase\Exception\AuthException;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View|RedirectResponse
    {
        // Firebase sends "oobCode" in the query string
        if (!$request->has('oobCode')) {
            return redirect()->route('login')->withErrors(['email' => 'Enlace de restablecimiento inválido o expirado.']);
        }

        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'oobCode' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);
            
            // Execute the password reset via Firebase
            $firebaseAuth->confirmPasswordReset($request->oobCode, $request->password);
            
            return redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida correctamente. ¡Ya puedes iniciar sesión!');
        } catch (AuthException $e) {
            return back()->withErrors(['password' => 'El enlace de restablecimiento es inválido o ya fue utilizado. Por favor solicita uno nuevo.']);
        } catch (\Exception $e) {
            return back()->withErrors(['password' => 'Ocurrió un error inesperado. Inténtalo de nuevo.']);
        }
    }
}
