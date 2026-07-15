<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Contract\Storage;
use Illuminate\Support\Facades\File;

class FirestoreInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firestore:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza imágenes locales a Firebase Storage y crea documentos en Firestore';

    /**
     * Execute the console command.
     */
    public function handle(Firestore $firestore, Storage $storage)
    {
        $this->info('Iniciando inicialización de Firestore y Storage...');

        $directory = public_path('images/destinations');
        if (!File::exists($directory)) {
            $this->error("El directorio {$directory} no existe.");
            return;
        }

        $files = File::files($directory);
        $bucket = $storage->getBucket();
        $db = $firestore->database();
        $collection = $db->collection('destinos');

        // Limpiar colección (opcional, para evitar duplicados en cada ejecución, lo dejamos simple por ahora o iteramos)
        // En este caso, usaremos el nombre del archivo sin extensión como ID del documento para que haga upsert.

        $positions = [
            ['x' => -3, 'y' => 1, 'z' => 2],
            ['x' => 3, 'y' => 2, 'z' => -1],
            ['x' => 0, 'y' => 3, 'z' => -4],
            ['x' => -4, 'y' => 0.5, 'z' => -2],
            ['x' => 4, 'y' => 1.5, 'z' => 3],
        ];

        foreach ($files as $index => $file) {
            $filename = $file->getFilename();
            $basename = $file->getFilenameWithoutExtension();
            $path = $file->getPathname();

            $this->info("Subiendo imagen: {$filename}");

            // Subir a Storage
            $firebasePath = 'destinations/' . $filename;
            $imageUrl = '';
            
            try {
                $object = $bucket->upload(
                    fopen($path, 'r'),
                    ['name' => $firebasePath]
                );
                $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
                $imageUrl = "https://storage.googleapis.com/{$bucket->name()}/{$firebasePath}";
            } catch (\Exception $e) {
                $this->error("No se pudo subir a Storage (asegúrate de que exista tu bucket de Firebase Storage): " . $e->getMessage());
                // Fallback a URL local
                $imageUrl = "/images/destinations/" . $filename;
            }

            $pos = $positions[$index % count($positions)];

            $docRef = $collection->document($basename);
            $docRef->set([
                'title' => ucwords(str_replace('_', ' ', $basename)),
                'description' => "Experimenta la belleza y aventura en " . ucwords(str_replace('_', ' ', $basename)) . ". Un tour inolvidable en Tumbes.",
                'price' => rand(150, 450),
                'image_url' => $imageUrl,
                'x' => $pos['x'],
                'y' => $pos['y'],
                'z' => $pos['z'],
                'max_people' => rand(10, 40),
                'disabled_access' => (bool)rand(0, 1),
                'included' => "✔ Transporte ida y vuelta\n✔ Guía turístico oficial\n✔ Almuerzo típico de la región\n✔ Entradas a todos los atractivos",
            ]);

            $this->info("Documento creado/actualizado para: {$basename}");
        }

        $this->info('¡Inicialización completada!');
    }
}

