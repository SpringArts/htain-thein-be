<?php

namespace App\Services\Firebase;

use Google\Cloud\Firestore\FirestoreClient;

class FirebaseConnectionService
{
    public static function getConnection(): FirestoreClient
    {
        $credentialsPath = config('services.firebase.credentials');

        if (! is_string($credentialsPath)) {
            throw new \Exception('The credentials path is not a string.');
        }

        return new FirestoreClient([
            'keyFilePath' => base_path($credentialsPath),
        ]);
    }
}
