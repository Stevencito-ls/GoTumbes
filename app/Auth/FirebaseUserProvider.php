<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class FirebaseUserProvider implements UserProvider
{
    protected $firestore;

    public function __construct()
    {
        $this->firestore = app(Firestore::class);
    }

    public function retrieveById($identifier)
    {
        try {
            $doc = $this->firestore->database()->collection('usuarios')->document($identifier)->snapshot();
            if ($doc->exists()) {
                $data = $doc->data();
                $data['id'] = $doc->id();
                return new FirebaseUser($data);
            }
        } catch (\Exception $e) {
            Log::error("Error retrieving user from Firebase: " . $e->getMessage());
        }

        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        try {
            $doc = $this->firestore->database()->collection('usuarios')->document($identifier)->snapshot();
            if ($doc->exists()) {
                $data = $doc->data();
                if (isset($data['remember_token']) && $data['remember_token'] === $token) {
                    $data['id'] = $doc->id();
                    return new FirebaseUser($data);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error retrieving user by token from Firebase: " . $e->getMessage());
        }

        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        try {
            $docRef = $this->firestore->database()->collection('usuarios')->document($user->getAuthIdentifier());
            $docRef->update([
                ['path' => 'remember_token', 'value' => $token]
            ]);
        } catch (\Exception $e) {
            Log::error("Error updating remember token in Firebase: " . $e->getMessage());
        }
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) || !isset($credentials['email'])) {
            return null;
        }

        try {
            $docs = $this->firestore->database()->collection('usuarios')->where('email', '=', $credentials['email'])->limit(1)->documents();
            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $data = $doc->data();
                    $data['id'] = $doc->id();
                    return new FirebaseUser($data);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error retrieving user by credentials from Firebase: " . $e->getMessage());
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (!isset($credentials['password'])) {
            return false;
        }

        try {
            $firebaseAuth = app(\Kreait\Firebase\Contract\Auth::class);
            $signInResult = $firebaseAuth->signInWithEmailAndPassword($credentials['email'], $credentials['password']);
            return $signInResult != null;
        } catch (\Exception $e) {
            // Si falla en Firebase Auth (ej: usuario no migrado o contraseña incorrecta en Auth), 
            // intentamos el fallback con el hash local guardado en Firestore.
            if ($user->getAuthPassword()) {
                return Hash::check($credentials['password'], $user->getAuthPassword());
            }
            return false;
        }
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // No automatic rehashing supported currently.
    }
}
