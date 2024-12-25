<?php

namespace App\Models;

class Password
{
    private ?int $id = null;
    private string $hash;
    private string $createdAt;
    private string $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setHash(string $hash)
    {
        $this->hash = $hash;
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
