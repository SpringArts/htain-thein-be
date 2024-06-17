<?php

namespace App\Services\AuthServices;

use App\Models\User;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class AuthService
{
    public function handleAuthentication(SocialiteUser $socialiteUser, string $provider): string
    {
        $newUser = $this->store($socialiteUser, $provider);
        $this->login($newUser);
        $token = $this->createToken($newUser);

        return $token;
    }

    private function store(SocialiteUser $socialiteUser, string $provider): User
    {
        return User::updateOrCreate(
            ['email' => $socialiteUser->getEmail()], // Use getEmail() method
            [
                'name' => $socialiteUser->getName(), // Use getName() method
                'provider_id' => $socialiteUser->getId(), // Use getId() method
                'provider_name' => $provider,
            ]
        );
    }

    private function login(User $newUser): void
    {
        auth()->login($newUser);
    }

    public function createToken(User $newUser): string
    {
        return $newUser->createToken('authToken')->plainTextToken;
    }
}
