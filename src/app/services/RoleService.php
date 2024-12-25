<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function addRoleToUser(int $userId, array $roles)
    {
        return $this->roleRepository->assignRoleToUser($roles, $userId);
    }
}
