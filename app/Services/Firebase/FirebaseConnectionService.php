<?php

namespace App\Services\Firebase;

use Google\Cloud\Firestore\FirestoreClient;

class FirebaseConnectionService
{
    public static function getConnection(): FirestoreClient
    {
        $credentialsPath = config('services.firebase.credentials');
        return new FirestoreClient([
            'keyFilePath' => base_path($credentialsPath),
        ]);
    }
}
