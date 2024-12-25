<?php

namespace App\Models;

class Role
{
    private int $id;
    private string $label;

    public function getId()
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }
}
