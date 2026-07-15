<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $email = Auth::user()->email;
            $cacheKey = 'is_admin_' . md5($email);
            
            $isAdmin = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($email) {
                $firestore = app(Firestore::class);
                $db = $firestore->database();
                
                $usersRef = $db->collection('usuarios');
                $query = $usersRef->where('email', '=', $email)->limit(1);
                $documents = $query->documents();
                
                $isAdminRole = false;
                $userDocExists = false;

                foreach ($documents as $document) {
                    if ($document->exists()) {
                        $userDocExists = true;
                        $data = $document->data();
                        if (isset($data['role']) && $data['role'] === 'admin') {
                            $isAdminRole = true;
                        }
                    }
                }

                // Si el documento no existe en Firestore, lo creamos con rol 'user'
                if (!$userDocExists) {
                    $newUserDoc = $usersRef->newDocument();
                    $newUserDoc->set([
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'role' => 'user',
                        'created_at' => time()
                    ]);
                }
                
                return $isAdminRole;
            });

            if (!$isAdmin) {
                return redirect()->route('home')->with('error', 'No tienes permisos de administrador (requerido en Firebase).');
            }

        } catch (\Exception $e) {
            Log::error("Error verificando rol en Firestore: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'Error al verificar permisos en Firebase.');
        }

        return $next($request);
    }
}
