<?php

namespace App\Services;

use Kreait\Firebase\Contract\Firestore;

class FirebaseService
{
    protected $firestore;

    public function __construct(Firestore $firestore)
    {
        $this->firestore = $firestore;
    }

    public function getDatabase()
    {
        return $this->firestore->database();
    }

    public function getCollection($collectionName)
    {
        return $this->getDatabase()->collection($collectionName);
    }
}
