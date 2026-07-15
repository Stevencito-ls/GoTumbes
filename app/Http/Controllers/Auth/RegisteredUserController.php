<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
        $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);
        $db = $firestore->database();
        $usersRef = $db->collection('usuarios');

        // Verificar si el email ya existe en Firestore
        $existing = $usersRef->where('email', '=', $request->email)->limit(1)->documents();
        foreach ($existing as $doc) {
            if ($doc->exists()) {
                throw ValidationException::withMessages([
                    'email' => 'The email has already been taken.',
                ]);
            }
        }

        try {
            // Crear usuario en Firebase Authentication
            $createdUser = $firebaseAuth->createUser([
                'email' => $request->email,
                'password' => $request->password,
                'displayName' => $request->name,
            ]);

            // Enviar correo de verificación de Firebase
            $firebaseAuth->sendEmailVerificationLink($request->email);

            $uid = $createdUser->uid;
            
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'Error al crear la cuenta en Firebase: ' . $e->getMessage(),
            ]);
        }

        // Crear documento en Firestore con el UID de Firebase Auth
        $newUserDoc = $usersRef->document($uid);
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mantenemos el hash local por retrocompatibilidad temporal si se requiere
            'role' => 'user',
            'created_at' => time()
        ];
        $newUserDoc->set($userData);

        $userData['id'] = $uid;
        $user = new \App\Auth\FirebaseUser($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
