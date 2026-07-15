<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);
        $emailVerified = false;

        try {
            $firebaseUser = $firebaseAuth->getUser($user->id);
            $emailVerified = $firebaseUser->emailVerified;
        } catch (\Exception $e) {
            // Ignorar si falla la obtención desde Auth
        }

        return view('profile.edit', [
            'user' => $user,
            'emailVerified' => $emailVerified,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
        $db = $firestore->database();
        
        try {
            $db->collection('usuarios')->document($user->id)->update([
                ['path' => 'name', 'value' => $validated['name']],
                ['path' => 'phone', 'value' => $validated['phone'] ?? null],
            ]);
            
            // Actualizar atributo en sesión
            $user->attributes['name'] = $validated['name'];
            $user->attributes['phone'] = $validated['phone'] ?? null;
            
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->withErrors(['error' => 'No se pudo actualizar el perfil.']);
        }

        return Redirect::route('profile.edit')->with('status', 'Perfil actualizado con éxito.');
    }

    /**
     * Send email verification link.
     */
    public function verifyEmail(Request $request): RedirectResponse
    {
        $user = $request->user();
        $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);

        try {
            $firebaseAuth->sendEmailVerificationLink($user->email);
            return Redirect::route('profile.edit')->with('status', 'Se ha enviado un enlace de verificación a tu correo.');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->withErrors(['error' => 'No se pudo enviar el correo: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = $request->user();

        // Validar contraseña actual
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->getAuthPassword())) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        try {
            $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);
            $firebaseAuth->changeUserPassword($user->id, $request->password);

            // Actualizar en Firestore
            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $firestore->database()->collection('usuarios')->document($user->id)->update([
                ['path' => 'password', 'value' => \Illuminate\Support\Facades\Hash::make($request->password)]
            ]);

            $user->attributes['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            
            return Redirect::route('profile.edit')->with('status', 'Contraseña actualizada con éxito.');
        } catch (\Exception $e) {
            return back()->withErrors(['password' => 'Error al actualizar contraseña: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        
        try {
            $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);
            $firebaseAuth->deleteUser($user->id);

            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $firestore->database()->collection('usuarios')->document($user->id)->delete();
        } catch (\Exception $e) {
            // Ignorar y continuar eliminando sesión
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
