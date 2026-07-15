<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Log;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = [];
        
        try {
            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $db = $firestore->database();
            $doc = $db->collection('configuracion')->document('global')->snapshot();
            
            if ($doc->exists()) {
                $settings = $doc->data();
            }
            
        } catch (\Exception $e) {
            Log::error('Error leyendo configuracion desde Firebase: ' . $e->getMessage());
            session()->flash('error', 'Sin conexión a Firebase para leer configuraciones.');
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $db = $firestore->database();
            $db->collection('configuracion')->document('global')->set($validated, ['merge' => true]);
            
            \Illuminate\Support\Facades\Cache::forget('global_settings');
            
            return redirect()->back()->with('success', 'Configuraciones actualizadas correctamente.');
        } catch (\Exception $e) {
            Log::error('Error guardando configuracion: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar la configuración.');
        }
    }
}
