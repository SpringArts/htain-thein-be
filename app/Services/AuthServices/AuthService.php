<?php


namespace  App\Services\AuthServices;

use App\Models\User;


class AuthService
{
    public function handleAuthentication($user, $provider)
    {
        $newUser =  $this->store($user, $provider);
        $this->login($newUser);
        $token = $this->createToken($newUser);
        return $token;
    }


    private function store($user, $provider)
    {
        return User::updateOrCreate(
            [
                'provider_id' => $user->getId(),
                'provider_name' => $provider,
            ],
            [
                'name' => $user->getName(),
                'email' => $user->getEmail(),

            ]
        );
    }

    private function login($newUser)
    {
        return auth()->login($newUser);
    }

    public function createToken($newUser)
    {
        return $newUser->createToken('authToken')->plainTextToken;
    }
}
