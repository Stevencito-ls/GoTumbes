<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FirestoreSyncTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class DestinationController extends Controller
{
    use FirestoreSyncTrait;

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image',
            'included' => 'nullable|string',
            'max_people' => 'nullable|integer',
        ]);

        $data = $request->except('image');
        $data['disabled_access'] = $request->has('disabled_access');
        
        if ($request->hasFile('image')) {
            $data['image_url'] = $this->uploadToStorage($request->file('image'));
        }

        $documentId = Str::slug($data['title']);
        try {
            $this->syncToFirestore('destinos', $documentId, $data);
            Cache::forget('public_destinations');
            Cache::forget('admin_dashboard_stats');
            return redirect()->back()->with('success', 'Destino creado correctamente en Firebase.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image',
            'included' => 'nullable|string',
            'max_people' => 'nullable|integer',
        ]);

        $data = $request->except(['image', '_method', '_token']);
        $data['disabled_access'] = $request->has('disabled_access');
        
        if ($request->hasFile('image')) {
            $data['image_url'] = $this->uploadToStorage($request->file('image'));
        }

        try {
            // Utilizamos el trait para sincronizar los datos. Si pasamos el mismo ID, lo actualizará/sobrescribirá usando set($data, ['merge' => true]) o similar.
            // Para asegurar merge en FirestoreSyncTrait, tal vez necesite soporte de merge.
            // Si el trait solo usa ->set($data), sobrescribirá.
            // Revisaré el trait o usaré Firestore directo aquí si es necesario.
            $this->syncToFirestore('destinos', $id, $data);
            Cache::forget('public_destinations');
            Cache::forget('admin_dashboard_stats');
            return redirect()->back()->with('success', 'Destino actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->deleteFromFirestore('destinos', $id);
            Cache::forget('public_destinations');
            Cache::forget('admin_dashboard_stats');
            return redirect()->back()->with('success', 'Destino eliminado de Firebase.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
