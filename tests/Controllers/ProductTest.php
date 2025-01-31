<?php
namespace AvoRed\Framework\Tests\Controllers;

use AvoRed\Framework\Tests\BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use AvoRed\Framework\Database\Models\Product;

class ProductTest extends BaseTestCase
{
    use RefreshDatabase;
    
    /* @runInSeparateProcess */
    public function testProductIndexRouteTest()
    {
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.product.index'))
            ->assertStatus(200)
            ->assertSee(__('avored::catalog.product.index.title'));
    }

    /* @runInSeparateProcess */
    public function testProductCreateRouteTest()
    {
        $this->createAdminUser()
            ->actingAs($this->user, 'admin')
            ->get(route('admin.product.create'))
            ->assertStatus(200)
            ->assertSee(__('avored::catalog.product.create.title'));
    }
}
