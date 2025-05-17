<?php

namespace Modules\Basicdata\Tests\Feature;

use Tests\TestCase;
use Modules\Basicdata\Models\Branch;
use Modules\Usermanagement\Models\User;
use Modules\Usermanagement\Models\Role;
use Modules\Usermanagement\Models\Permission;
use Modules\Usermanagement\Models\PermissionGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class BranchControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $adminRole;
    protected $branch;

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

        // Create a branch for testing
        $this->branch = Branch::create([
            'code' => 'TEST',
            'name' => 'Test Branch'
        ]);
    }

    #[Test]
    public function user_with_permission_can_view_branches_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.branch.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_view_branches_index()
    {
        // Create a role without permissions
        $role = Role::create(['name' => 'viewer', 'guard_name' => 'web']);

        // Create a user with the viewer role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.branch.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_create_branch()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.branch.create'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_create_branch()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.branch.create'));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_store_branch()
    {
        $branchData = [
            'code' => 'NEW',
            'name' => 'New Branch'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('basicdata.branch.store'), $branchData);

        $response->assertRedirect(route('basicdata.branch.index'));
        $this->assertDatabaseHas('branches', $branchData);
    }

    #[Test]
    public function user_without_permission_cannot_store_branch()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $branchData = [
            'code' => 'NEW',
            'name' => 'New Branch'
        ];

        $response = $this->actingAs($user)
            ->post(route('basicdata.branch.store'), $branchData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('branches', $branchData);
    }

    #[Test]
    public function user_with_permission_can_edit_branch()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.branch.edit', $this->branch->id));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_edit_branch()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.branch.edit', $this->branch->id));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_update_branch()
    {
        $updatedData = [
            'code' => 'UPD',
            'name' => 'Updated Branch'
        ];

        $response = $this->actingAs($this->user)
            ->put(route('basicdata.branch.update', $this->branch->id), $updatedData);

        $response->assertRedirect(route('basicdata.branch.index'));
        $this->assertDatabaseHas('branches', $updatedData);
    }

    #[Test]
    public function user_without_permission_cannot_update_branch()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $updatedData = [
            'code' => 'UPD',
            'name' => 'Updated Branch'
        ];

        $response = $this->actingAs($user)
            ->put(route('basicdata.branch.update', $this->branch->id), $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('branches', $updatedData);
    }

    #[Test]
    public function user_with_permission_can_delete_branch()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('basicdata.branch.destroy', $this->branch->id));

        $response->assertJson(['success' => true]);
        $this->assertSoftDeleted($this->branch);
    }

    #[Test]
    public function user_without_permission_cannot_delete_branch()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->delete(route('basicdata.branch.destroy', $this->branch->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('branches', ['id' => $this->branch->id, 'deleted_at' => null]);
    }

    #[Test]
    public function user_with_permission_can_export_branches()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.branch.export'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_export_branches()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.branch.export'));

        $response->assertStatus(403);
    }
}
