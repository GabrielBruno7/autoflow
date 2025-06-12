<?php

namespace App\Domain\User;

use App\Models\User as AuthUser;
use Illuminate\Support\Facades\Hash;

class User extends AuthUser
{
    private string $id;
    private string $email;
    private string $password;
    private string $token;

    private UserPersistenceInterface $persistence;

    public function __construct(UserPersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }

    private function getPersistence(): UserPersistenceInterface
    {
        return $this->persistence;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): self
    {
        if (strlen($password) < 6) {
            throw new \InvalidArgumentException('A senha deve ter pelo menos 6 caracteres.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new \InvalidArgumentException('A senha deve conter pelo menos uma letra maiúscula.');
        }

        $this->password = $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function loadUserByEmail(): self
    {
        if (!$this->getPersistence()->loadUserByEmail($this)) {
            throw new \RuntimeException('Usuário não encontrado.'); 
        }

        return $this;
    }

    public function checkPassword(string $password): self
    {
        if (!Hash::check($password, $this->getPassword())) {
            throw new \RuntimeException('Credenciais inválidas'); 
        }

        return $this;
    }

    public function generateToken(): self
    {
        $this->setToken(
            parent::createToken('login')->plainTextToken
        );

        return $this;
    }
}