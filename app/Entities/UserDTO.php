<?php


namespace  App\Entities;

class UserDTO
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $account_status;
    public string $role;
    public string $provider_name;
    public string $provider_id;


    public function __construct(string $name, string $email, string $password, string $account_status, string $role, string $provider_name, string $provider_id)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->account_status = $account_status;
        $this->role = $role;
        $this->provider_name = $provider_name;
        $this->provider_id = $provider_id;
    }
}
