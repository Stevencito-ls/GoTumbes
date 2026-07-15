<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $destinations = [];
        try {
            $stats = Cache::remember('admin_dashboard_stats', 60, function () {
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
                
                $resCount = 0;
                $tIncome = 0;
                $incomeByDest = [];
                
                $reservationsCollection = $db->collection('reservas')->documents();
                foreach ($reservationsCollection as $res) {
                    if ($res->exists()) {
                        $rData = $res->data();
                        $resCount++;
                        
                        $status = $rData['status'] ?? 'paid';
                        
                        if ($status === 'paid') {
                            $paid = 0;
                            if (isset($rData['total_paid'])) {
                                $paid = (float)$rData['total_paid'];
                            } elseif (isset($rData['total'])) {
                                $paid = (float)$rData['total'];
                            } elseif (isset($rData['price'])) {
                                $paid = (float)$rData['price'];
                            }
                            $tIncome += $paid;
                            
                            $destName = $rData['destination_title'] ?? 'Otros';
                            $destName = preg_replace('/([a-z])([A-Z])/s', '$1 $2', $destName);
                            
                            if (!isset($incomeByDest[$destName])) {
                                $incomeByDest[$destName] = 0;
                            }
                            $incomeByDest[$destName] += $paid;
                        }
                    }
                }
                
                return [
                    'destinations' => $dests,
                    'reservationsCount' => $resCount,
                    'totalIncome' => $tIncome,
                    'chartLabels' => array_keys($incomeByDest),
                    'chartData' => array_values($incomeByDest),
                ];
            });

            $destinations = $stats['destinations'];
            $reservationsCount = $stats['reservationsCount'];
            $totalIncome = $stats['totalIncome'];
            $chartLabels = $stats['chartLabels'];
            $chartData = $stats['chartData'];
            
        } catch (\Exception $e) {
            Log::error('Error leyendo Firebase en admin: ' . $e->getMessage());
            session()->flash('error', 'Error al conectar con la base de datos de Firebase. Revisa la configuración de tu conexión.');
            $reservationsCount = 0;
            $totalIncome = 0;
            $chartLabels = [];
            $chartData = [];
        }

        return view('admin.dashboard', compact('destinations', 'reservationsCount', 'totalIncome', 'chartLabels', 'chartData'));
    }
}
