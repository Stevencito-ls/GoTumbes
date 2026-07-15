<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function index()
    {
        try {
            $firestore = app(Firestore::class);
            $db = $firestore->database();
            $usersRef = $db->collection('usuarios');
            $documents = $usersRef->documents();
            
            $users = [];
            foreach ($documents as $document) {
                if ($document->exists()) {
                    $user = $document->data();
                    $user['id'] = $document->id();
                    $users[] = $user;
                }
            }

            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudieron cargar los usuarios de Firebase: ' . $e->getMessage());
        }
    }

    public function updateRole(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        try {
            $firestore = app(Firestore::class);
            $db = $firestore->database();
            $usersRef = $db->collection('usuarios');
            $doc = $usersRef->document($id);
            
            $doc->update([
                ['path' => 'role', 'value' => $request->role]
            ]);

            // Obtener el correo del usuario para limpiar el caché
            $userData = $doc->snapshot()->data();
            if (isset($userData['email'])) {
                $cacheKey = 'is_admin_' . md5($userData['email']);
                \Illuminate\Support\Facades\Cache::forget($cacheKey);
            }

            return redirect()->back()->with('success', 'Rol actualizado en Firebase.');
        } catch (\Exception $e) {
            Log::error("Error actualizando rol en Firestore: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el rol.');
        }
    }
}
