<?php

namespace AvoRed\Framework\Tests\Controllers;

use AvoRed\Framework\Tests\BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use AvoRed\Framework\Database\Models\Role;
use AvoRed\Framework\Database\Models\Permission;
use AvoRed\Framework\Support\Facades\Permission as AvoRedPermission;

class RoleTest extends BaseTestCase
{
    use RefreshDatabase;
    
    /* @runInSeparateProcess */
    public function testRoleIndexRouteTest()
    {
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.role.index'))
            ->assertStatus(200)
            ->assertSee(__('avored::system.role.index.title'));
    }

    /* @runInSeparateProcess */
    public function testRoleCreateRouteTest()
    {
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.role.create'))
            ->assertStatus(200)
            ->assertSee(__('avored::system.role.create.title'));
    }

    /* @runInSeparateProcess */
    public function testRoleStoreRouteTest()
    {
        $data = ['name' => 'test role name'];
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->post(route('admin.role.store', $data))
            ->assertRedirect(route('admin.role.index'));

        $this->assertDatabaseHas('roles', ['name' => 'test role name']);
    }

    /* @runInSeparateProcess */
    public function testRoleEditRouteTest()
    {
        $role = factory(Role::class)->create();
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.role.edit', $role->id))
            ->assertStatus(200)
            ->assertSee(__('avored::system.role.edit.title'));
    }

    /* @runInSeparateProcess */
    public function testRoleUpdateRouteTest()
    {
        $role = factory(Role::class)->create();
        $role->name = "updated role name";
        $data = $role->toArray();

        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->put(route('admin.role.update', $role->id), $data)
            ->assertRedirect(route('admin.role.index'));

        $this->assertDatabaseHas('roles', ['name' => 'updated role name']);
    }

    /* @runInSeparateProcess */
    public function testRoleDestroyRouteTest()
    {
        $role = factory(Role::class)->create();
        
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->delete(route('admin.role.destroy', $role->id))
            ->assertStatus(200);

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    /* @runInSeparateProcess */
    public function testRoleStoreWithPermissionsRouteTest()
    {
        $permissionList = AvoRedPermission::all()->first()->permissionList;
        $permissions = collect();
        foreach ($permissionList as $permission) {
            $permissions->push($permission->routes());
        }
        
        $data = ['name' => 'test role name', 'permissions' => $permissions->toArray()];
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->post(route('admin.role.store', $data))
            ->assertRedirect(route('admin.role.index'));

        $this->assertDatabaseHas('roles', ['name' => 'test role name']);
    }

    /* @runInSeparateProcess */
    public function testRoleUpdateWithPermissionsRouteTest()
    {
        $permissionList = AvoRedPermission::all()->first()->permissionList;
        $permissions = collect();
        foreach ($permissionList as $permission) {
            $permissions->push($permission->routes());
        }
        
        $role = factory(Role::class)->create();
        $role->name = "updated role name";
        $data = $role->toArray();
        $data['permissions'] = $permissions->toArray();
        
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->put(route('admin.role.update', $role->id), $data)
            ->assertRedirect(route('admin.role.index'));

        $this->assertDatabaseHas('roles', ['name' => 'updated role name']);
    }
}
