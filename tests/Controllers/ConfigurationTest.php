<?php
namespace AvoRed\Framework\Tests\Controllers;

use AvoRed\Framework\Tests\BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use AvoRed\Framework\Database\Models\Configuration;

class ConfigurationTest extends BaseTestCase
{
    use RefreshDatabase;
    
    /* @runInSeparateProcess */
    public function testConfigurationIndexRouteTest()
    {
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.configuration.index'))
            ->assertStatus(200)
            ->assertSee(__('avored::system.configuration.nav.basic_setting'));
    }

    /* @runInSeparateProcess */
    public function testCategoryStoreRouteTest()
    {
        $data = ['site_title' => 'test site title'];
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->post(route('admin.configuration.store', $data))
            ->assertRedirect(route('admin.configuration.index'));

        $this->assertDatabaseHas('configurations', ['code' => 'site_title']);
    }
}
