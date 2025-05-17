<?php

namespace Modules\Basicdata\Tests\Feature;

use Tests\TestCase;
use Modules\Basicdata\Models\Currency;
use Modules\Usermanagement\Models\User;
use Modules\Usermanagement\Models\Role;
use Modules\Usermanagement\Models\Permission;
use Modules\Usermanagement\Models\PermissionGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class CurrencyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $adminRole;
    protected $currency;

    protected function setUp(): void
    {
        parent::setUp();

        // Create permission group first
        $permissionGroup = PermissionGroup::create([
            'name' => 'basic-data',
            'slug' => 'basic-data'
        ]);

        // Create permissions with permission_group_id
        Permission::create([
            'name' => 'basic-data.create',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);
        Permission::create([
            'name' => 'basic-data.read',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);
        Permission::create([
            'name' => 'basic-data.update',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);
        Permission::create([
            'name' => 'basic-data.delete',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);
        Permission::create([
            'name' => 'basic-data.export',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        // Create admin role with all permissions
        $this->adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->adminRole->givePermissionTo(Permission::all());

        // Create a user with admin role
        $this->user = User::factory()->create();
        $this->user->assignRole($this->adminRole);

        // Create a currency for testing
        $this->currency = Currency::create([
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'decimal_places' => 2,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
            'authorized_by' => null
        ]);
    }

    #[Test]
    public function user_with_permission_can_view_currencies_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.currency.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_view_currencies_index()
    {
        // Create a role without permissions
        $role = Role::create(['name' => 'viewer', 'guard_name' => 'web']);

        // Create a user with the viewer role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.currency.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_create_currency()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.currency.create'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_create_currency()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.currency.create'));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_store_currency()
    {
        $currencyData = [
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => '€',
            'decimal_places' => 2
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('basicdata.currency.store'), $currencyData);

        $response->assertRedirect(route('basicdata.currency.index'));

        // Only check the fields we're explicitly setting
        $this->assertDatabaseHas('currencies', [
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => '€',
            'decimal_places' => 2
        ]);
    }

    #[Test]
    public function user_without_permission_cannot_store_currency()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $currencyData = [
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => '€',
            'decimal_places' => 2
        ];

        $response = $this->actingAs($user)
                         ->post(route('basicdata.currency.store'), $currencyData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('currencies', [
            'code' => 'EUR',
            'name' => 'Euro'
        ]);
    }

    #[Test]
    public function user_with_permission_can_edit_currency()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.currency.edit', $this->currency->id));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_edit_currency()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.currency.edit', $this->currency->id));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_update_currency()
    {
        $updatedData = [
            'id' => $this->currency->id,  // Include the ID in the request
            'code' => 'GBP',
            'name' => 'British Pound',
            'symbol' => '£',
            'decimal_places' => 2
        ];

        $response = $this->actingAs($this->user)
                         ->put(route('basicdata.currency.update', $this->currency->id), $updatedData);

        $response->assertRedirect(route('basicdata.currency.index'));

        // Only check the fields we're explicitly setting
        $this->assertDatabaseHas('currencies', [
            'id' => $this->currency->id,
            'code' => 'GBP',
            'name' => 'British Pound',
            'symbol' => '£',
            'decimal_places' => 2
        ]);
    }

    #[Test]
    public function user_without_permission_cannot_update_currency()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $updatedData = [
            'id' => $this->currency->id,  // Include the ID in the request
            'code' => 'GBP',
            'name' => 'British Pound',
            'symbol' => '£',
            'decimal_places' => 2
        ];

        $response = $this->actingAs($user)
                         ->put(route('basicdata.currency.update', $this->currency->id), $updatedData);

        $response->assertStatus(403);

        // Verify the currency wasn't updated - check that it still has the original values
        $this->assertDatabaseHas('currencies', [
            'id' => $this->currency->id,
            'code' => 'USD',  // Original value
            'name' => 'US Dollar'  // Original value
        ]);
    }

    #[Test]
    public function user_with_permission_can_delete_currency()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('basicdata.currency.destroy', $this->currency->id));

        $response->assertJson(['success' => true]);
        $this->assertSoftDeleted($this->currency);
    }

    #[Test]
    public function user_without_permission_cannot_delete_currency()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->delete(route('basicdata.currency.destroy', $this->currency->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('currencies', ['id' => $this->currency->id, 'deleted_at' => null]);
    }

    #[Test]
    public function user_with_permission_can_export_currencies()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.currency.export'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_export_currencies()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.currency.export'));

        $response->assertStatus(403);
    }
}
