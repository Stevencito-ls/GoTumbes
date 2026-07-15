<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function destinations()
    {
        return view('destinations.index');
    }

    public function index()
    {
        $destinations = [];
        
        try {
            $destinations = Cache::remember('public_destinations', 300, function () {
                $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
                $db = $firestore->database();
                $collection = $db->collection('destinos')->documents();
                $dests = [];
                foreach ($collection as $document) {
                    if ($document->exists()) {
                        $data = $document->data();
                        $data['id'] = $document->id();
                        $dests[] = $data;
                    }
                }
                return $dests;
            });
        } catch (\Exception $e) {
            Log::error('Error leyendo Firebase: ' . $e->getMessage());
            session()->flash('warning', 'Sin conexión a Firebase. Mostrando destinos de demostración (Offline).');
            // Fallback
            $destinations = [
                [
                    'id' => 'CatedralTumbes',
                    'title' => 'Catedral Tumbes',
                    'description' => 'Un símbolo de fe y arquitectura.',
                    'price' => 150,
                    'image_url' => '/images/destinations/CatedralTumbes.jpg',
                    'x' => -3, 'y' => 1, 'z' => 2
                ],
                [
                    'id' => 'PuntaSal',
                    'title' => 'Punta Sal',
                    'description' => 'Playas paradisíacas y sol todo el año.',
                    'price' => 300,
                    'image_url' => '/images/destinations/PuntaSal.jpg',
                    'x' => 3, 'y' => 2, 'z' => -1
                ],
            ];
        }

        return view('home', compact('destinations'));
    }

    public function apiDestinations()
    {
        try {
            $dests = Cache::remember('public_destinations', 300, function () {
                $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
                $db = $firestore->database();
                $collection = $db->collection('destinos')->documents();
                $destinations = [];
                foreach ($collection as $document) {
                    if ($document->exists()) {
                        $data = $document->data();
                        $data['id'] = $document->id();
                        $destinations[] = $data;
                    }
                }
                return $destinations;
            });
            return response()->json($dests);
        } catch (\Exception $e) {
            Log::error('Error leyendo Firebase API: ' . $e->getMessage());
            return response()->json([
                [
                    'id' => 'CatedralTumbes',
                    'title' => 'Catedral Tumbes',
                    'description' => 'Un símbolo de fe y arquitectura.',
                    'price' => 150,
                    'image_url' => '/images/destinations/CatedralTumbes.jpg',
                    'x' => -3, 'y' => 1, 'z' => 2
                ],
                [
                    'id' => 'PuntaSal',
                    'title' => 'Punta Sal',
                    'description' => 'Playas paradisíacas y sol todo el año.',
                    'price' => 300,
                    'image_url' => '/images/destinations/PuntaSal.jpg',
                    'x' => 3, 'y' => 2, 'z' => -1
                ],
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $db = $firestore->database();
            $doc = $db->collection('destinos')->document($id)->snapshot();
            
            if (!$doc->exists()) {
                abort(404);
            }
            
            $destination = $doc->data();
            $destination['id'] = $doc->id();
            
            return view('destinations.show', compact('destination'));
            
        } catch (\Exception $e) {
            Log::error('Error buscando destino: ' . $e->getMessage());
            abort(404);
        }
    }

    public function checkout(string $id)
    {
        try {
            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $db = $firestore->database();
            $doc = $db->collection('destinos')->document($id)->snapshot();
            
            if (!$doc->exists()) {
                abort(404);
            }
            
            $destination = $doc->data();
            $destination['id'] = $doc->id();
            
            return view('destinations.checkout', compact('destination'));
            
        } catch (\Exception $e) {
            Log::error('Error cargando checkout: ' . $e->getMessage());
            abort(404);
        }
    }

    public function processCheckout(Request $request, string $id)
    {
        // Validación para pagos manuales (Yape/Plin)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'reservation_date' => 'required|date|after_or_equal:today',
            'tickets' => 'required|integer|min:1',
            'payment_method' => 'required|in:yape,plin',
            'operation_number' => 'required|string|max:50',
        ]);

        try {
            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $db = $firestore->database();
            
            $destDoc = $db->collection('destinos')->document($id)->snapshot();
            
            if (!$destDoc->exists()) {
                return back()->with('error', 'Destino no encontrado.');
            }
            
            $destination = $destDoc->data();
            $totalPrice = $destination['price'] * $validated['tickets'];
            
            // Crear reserva en Firestore
            $reservationId = uniqid('res_');
            $db->collection('reservas')->document($reservationId)->set([
                'destination_id' => $id,
                'destination_title' => $destination['title'],
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'],
                'reservation_date' => $validated['reservation_date'],
                'tickets' => $validated['tickets'],
                'payment_method' => $validated['payment_method'],
                'operation_number' => $validated['operation_number'],
                'total_paid' => $totalPrice,
                'status' => 'pending', // Pagos por yape/plin quedan pendientes de validación del admin
                'created_at' => time()
            ]);
            
            Cache::forget('admin_reservations');
            Cache::forget('admin_dashboard_stats');
            
            return redirect()->route('destinations.voucher', $reservationId)->with('success', '¡Pago procesado con éxito!');
            
        } catch (\Exception $e) {
            Log::error('Error procesando pago: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al procesar tu pago. Inténtalo de nuevo.');
        }
    }

    public function downloadVoucher(string $reservationId)
    {
        try {
            $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
            $db = $firestore->database();
            $resDoc = $db->collection('reservas')->document($reservationId)->snapshot();
            
            if (!$resDoc->exists()) {
                abort(404, 'Reserva no encontrada');
            }
            
            $reservation = $resDoc->data();
            $reservation['id'] = $resDoc->id();
            
            // Fetch destination info
            $destDoc = $db->collection('destinos')->document($reservation['destination_id'])->snapshot();
            $destination = $destDoc->exists() ? $destDoc->data() : [];
            
            $pdf = Pdf::loadView('destinations.voucher', compact('reservation', 'destination'));
            return $pdf->download('comprobante-' . $reservationId . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('Error generando voucher: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo generar el voucher.');
        }
    }
}
