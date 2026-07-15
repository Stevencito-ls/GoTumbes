<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\FirebaseService;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = [];
        
        try {
            $reservations = Cache::remember('admin_reservations', 60, function () {
                $firebaseService = app(FirebaseService::class);
                $collection = $firebaseService->getCollection('reservas')->documents();
                $res = [];
                
                foreach ($collection as $document) {
                    if ($document->exists()) {
                        $data = $document->data();
                        $data['id'] = $document->id();
                        $res[] = $data;
                    }
                }
                
                // Sort by created_at DESC in PHP
                usort($res, function($a, $b) {
                    $timeA = $a['created_at'] ?? 0;
                    $timeB = $b['created_at'] ?? 0;
                    return $timeB <=> $timeA;
                });
                
                return $res;
            });
            
        } catch (\Exception $e) {
            Log::error('Error leyendo reservas desde Firebase: ' . $e->getMessage());
            session()->flash('error', 'Sin conexión a Firebase para reservas.');
        }

        return view('admin.reservations.index', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:paid,rejected,pending'
        ]);

        try {
            $firebaseService = app(FirebaseService::class);
            $docRef = $firebaseService->getCollection('reservas')->document($id);
            
            if ($docRef->snapshot()->exists()) {
                $docRef->update([
                    ['path' => 'status', 'value' => $request->status],
                    ['path' => 'updated_at', 'value' => time()]
                ]);
                
                Cache::forget('admin_reservations');
                Cache::forget('admin_dashboard_stats');
                
                return redirect()->route('admin.reservations.index')
                    ->with('success', 'Estado de la reserva actualizado correctamente.');
            }
            
            return redirect()->route('admin.reservations.index')
                ->with('error', 'La reserva no existe.');
                
        } catch (\Exception $e) {
            Log::error('Error actualizando reserva: ' . $e->getMessage());
            return redirect()->route('admin.reservations.index')
                ->with('error', 'Hubo un problema actualizando la reserva.');
        }
    }
}
