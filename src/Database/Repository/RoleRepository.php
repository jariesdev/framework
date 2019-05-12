<?php

namespace AvoRed\Framework\Database\Repository;

use AvoRed\Framework\Database\Models\Role;
use AvoRed\Framework\Database\Contracts\RoleModelInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleModelInterface
{
    /**
     * Create Role Resource into a database
     * @param array $data
     * @return \AvoRed\Framework\Database\Models\Role $role
     */
    public function create(array $data): Role
    {
        return Role::create($data);
    }

    /**
     * Create Role Resource into a database
     * @param array $data
     * @return \AvoRed\Framework\Database\Models\Role $role
     */
    public function findAdminRole(): Role
    {
        return Role::whereName(Role::ADMIN)->first();
    }

    /**
     * find roles for the users
     * @return \Illuminate\Database\Eloquent\Collection $roles
     */
    public function all() : Collection
    {
        return Role::all();
    }
}