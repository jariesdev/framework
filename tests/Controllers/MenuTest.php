<?php

namespace AvoRed\Framework\Tests\Controllers;

use AvoRed\Framework\Tests\BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use AvoRed\Framework\Database\Models\Menu;

class MenuTest extends BaseTestCase
{
    use RefreshDatabase;
    
    /* @runInSeparateProcess */
    public function testMenuIndexRouteTest()
    {
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.menu-group.index'))
            ->assertStatus(200)
            ->assertSee(__('avored::cms.menu.index.title'));
    }

    /* @runInSeparateProcess */
    public function testMenuCreateRouteTest()
    {
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.menu-group.create'))
            ->assertStatus(200)
            ->assertSee(__('avored::cms.menu.create.title'));
    }

    /* @runInSeparateProcess */
    public function testMenuStoreRouteTest()
    {
        $menuJson = json_encode([['name' => 'menu name', 'url' => '/category/slug', 'submenus' => []]]);
        $data = ['name' => 'meun group name', 'identifier' => 'menu-group-name', 'menu_json' => $menuJson];
        $res = $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->post(route('admin.menu-group.store', $data))
            ->assertRedirect(route('admin.menu-group.index'));
        
        $this->assertDatabaseHas('menu_groups', ['name' => 'meun group name']);
        $this->assertDatabaseHas('menus', ['name' => 'menu name', 'url' => '/category/slug']);
    }
}
