<?php

namespace App\Traits;

use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Contract\Storage;

trait FirestoreSyncTrait
{
    /**
     * Sincroniza un array de datos hacia una colección de Firestore.
     *
     * @param string $collectionName
     * @param string $documentId
     * @param array $data
     * @return void
     */
    public function syncToFirestore(string $collectionName, string $documentId, array $data)
    {
        try {
            $firestore = app(Firestore::class);
            $db = $firestore->database();
            $collection = $db->collection($collectionName);
            $docRef = $collection->document($documentId);
            $docRef->set($data);
        } catch (\Exception $e) {
            \Log::error("Error sincronizando a Firestore: " . $e->getMessage());
            throw new \Exception("Error al conectar con Firebase Firestore para guardar datos.");
        }
    }

    /**
     * Elimina un documento de Firestore.
     */
    public function deleteFromFirestore(string $collectionName, string $documentId)
    {
        try {
            $firestore = app(Firestore::class);
            $db = $firestore->database();
            $collection = $db->collection($collectionName);
            $docRef = $collection->document($documentId);
            $docRef->delete();
        } catch (\Exception $e) {
            \Log::error("Error eliminando de Firestore: " . $e->getMessage());
            throw new \Exception("Error al conectar con Firebase Firestore para eliminar datos.");
        }
    }

    /**
     * Sube un archivo a Firebase Storage y retorna la URL pública.
     */
    public function uploadToStorage($file, string $pathPrefix = 'destinations/')
    {
        try {
            $storage = app(Storage::class);
            $bucket = $storage->getBucket();
            $filename = time() . '_' . $file->getClientOriginalName();
            $firebasePath = $pathPrefix . $filename;
            
            $object = $bucket->upload(
                fopen($file->getPathname(), 'r'),
                ['name' => $firebasePath]
            );

            $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
            return "https://storage.googleapis.com/{$bucket->name()}/{$firebasePath}";
        } catch (\Exception $e) {
            \Log::error("Error subiendo a Storage: " . $e->getMessage());
            return null;
        }
    }
}
