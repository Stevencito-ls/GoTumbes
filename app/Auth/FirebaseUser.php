<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class FirebaseUser implements Authenticatable
{
    public $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['id'] ?? null;
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'] ?? null;
    }

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function getRememberToken()
    {
        return $this->attributes['remember_token'] ?? null;
    }

    public function setRememberToken($value)
    {
        $this->attributes['remember_token'] = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }
}
