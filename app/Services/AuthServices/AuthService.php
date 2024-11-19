<?php

namespace App\Services\AuthServices;

use Illuminate\Support\Facades\Http;
use Log;


class AuthService
{
    public function fetchUserDetails(string $provider, string $accessToken): ?array
    {
        switch ($provider) {
            case 'google':
                return $this->fetchGoogleUserDetails($accessToken);
            case 'github':
                return $this->fetchGitHubUserDetails($accessToken);
            default:
                return null;
        }
    }

    private function fetchGoogleUserDetails(string $accessToken): ?array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($response->successful()) {
            $data = $response->json();
            return [
                'id' => $data['sub'],
                'name' => $data['name'],
                'email' => $data['email'],
                'access_token' => $accessToken,
                'username' => $data['email'],
            ];
        }

        return null;
    }

    private function fetchGitHubUserDetails(string $accessToken): ?array
    {
        $userResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.github.com/user');

        if (!$userResponse->successful()) {
            return null;
        }

        $data = $userResponse->json();
        Log::info('GitHub User Data:', $data);

        // Attempt to get the email from the initial response or fetch primary email if missing.
        $email = $data['email'] ?? $this->fetchPrimaryEmail($accessToken) ?? $data['login'] . '@example.com';

        return [
            'id' => $data['id'],
            'name' => $data['name'] ?? $data['login'],
            'email' => $email,
            'access_token' => $accessToken,
            'username' => $data['login'],
        ];
    }

    private function fetchPrimaryEmail(string $accessToken): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.github.com/user/emails');

        if ($response->failed()) {
            return null;
        }

        $emails = $response->json();
        Log::info('GitHub User Emails:', $emails);

        return collect($emails)->firstWhere('primary', true)['email'] ?? null;
    }
}
