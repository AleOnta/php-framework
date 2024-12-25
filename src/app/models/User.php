<?php

namespace App\Models;

class User
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $userName;
    protected string $email;
    protected ?int $passwordId;
    public string $birthdate;
    protected int $status;
    protected array $roles;
    protected string $createdAt;
    protected string $updatedAt;

    # GETTERS
    public function getId()
    {
        return $this->id;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function getUserName()
    {
        return $this->userName;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPasswordId()
    {
        return $this->passwordId;
    }
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    # SETTERS
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    public function setPasswordId(int $passwordId)
    {
        $this->passwordId = $passwordId;
    }
    public function setBirthdate(string $birthdate)
    {
        $this->birthdate = $birthdate;
    }
    public function setStatus(int $status)
    {
        return $this->status;
    }
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
