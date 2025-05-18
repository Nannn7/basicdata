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
    protected $parentBranch;

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

        // Create a parent branch for testing
        $this->parentBranch = Branch::create([
            'code' => 'PARENT',
            'name' => 'Parent Branch'
        ]);

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
    public function user_with_permission_can_store_branch_with_parent()
    {
        $branchData = [
            'code' => 'CHILD',
            'name' => 'Child Branch',
            'parent_id' => $this->parentBranch->id
        ];

        $response = $this->actingAs($this->user)
            ->post(route('basicdata.branch.store'), $branchData);

        $response->assertRedirect(route('basicdata.branch.index'));
        $this->assertDatabaseHas('branches', $branchData);

        // Verify the relationship
        $childBranch = Branch::where('code', 'CHILD')->first();
        $this->assertEquals($this->parentBranch->id, $childBranch->parent_id);
        $this->assertTrue($childBranch->parent()->exists());
        $this->assertEquals($this->parentBranch->id, $childBranch->parent->id);
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
    public function user_with_permission_can_update_branch_with_parent()
    {
        $updatedData = [
            'code' => 'UPD',
            'name' => 'Updated Branch',
            'parent_id' => $this->parentBranch->id
        ];

        $response = $this->actingAs($this->user)
            ->put(route('basicdata.branch.update', $this->branch->id), $updatedData);

        $response->assertRedirect(route('basicdata.branch.index'));
        $this->assertDatabaseHas('branches', $updatedData);

        // Verify the relationship
        $this->branch->refresh();
        $this->assertEquals($this->parentBranch->id, $this->branch->parent_id);
        $this->assertTrue($this->branch->parent()->exists());
        $this->assertEquals($this->parentBranch->id, $this->branch->parent->id);
    }

    #[Test]
    public function user_with_permission_can_remove_parent_from_branch()
    {
        // First set a parent
        $this->branch->update(['parent_id' => $this->parentBranch->id]);
        $this->assertEquals($this->parentBranch->id, $this->branch->parent_id);

        // Then remove it
        $updatedData = [
            'code' => 'UPD',
            'name' => 'Updated Branch',
            'parent_id' => null
        ];

        $response = $this->actingAs($this->user)
            ->put(route('basicdata.branch.update', $this->branch->id), $updatedData);

        $response->assertRedirect(route('basicdata.branch.index'));

        // Verify the relationship is removed
        $this->branch->refresh();
        $this->assertNull($this->branch->parent_id);
        $this->assertFalse($this->branch->parent()->exists());
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

    #[Test]
    public function branch_cannot_be_its_own_parent()
    {
        $updatedData = [
            'code' => 'SELF',
            'name' => 'Self-Referencing Branch',
            'parent_id' => $this->branch->id
        ];

        $response = $this->actingAs($this->user)
            ->from(route('basicdata.branch.edit', $this->branch->id))  // Tambahkan ini untuk mengetahui URL sebelumnya
            ->put(route('basicdata.branch.update', $this->branch->id), $updatedData);

        // Pastikan redirect back dengan kesalahan
        $response->assertRedirect();
        $response->assertSessionHasErrors('parent_id');

        // Periksa bahwa parent_id tidak berubah
        $this->branch->refresh();
        $this->assertNull($this->branch->parent_id);
    }

    #[Test]
    public function cannot_delete_branch_with_children()
    {
        // Create a child branch
        $childBranch = Branch::create([
            'code' => 'CHILD',
            'name' => 'Child Branch',
            'parent_id' => $this->parentBranch->id
        ]);

        // Verify the relationship is established
        $this->assertEquals($this->parentBranch->id, $childBranch->parent_id);
        $this->assertTrue($this->parentBranch->children()->exists());

        // Try to delete the parent branch
        $response = $this->actingAs($this->user)
            ->delete(route('basicdata.branch.destroy', $this->parentBranch->id));

        // Assert that the request fails with the expected message
        $response->assertJson([
            'success' => false,
            'message' => 'Cabang dengan anak cabang tidak dapat dihapus.'
        ]);
        $response->assertStatus(422); // Unprocessable Entity

        // Verify the parent branch was not deleted
        $this->assertDatabaseHas('branches', [
            'id' => $this->parentBranch->id,
            'deleted_at' => null
        ]);
    }

    #[Test]
    public function cannot_delete_multiple_branches_if_any_has_children()
    {
        // Create a child branch
        $childBranch = Branch::create([
            'code' => 'CHILD',
            'name' => 'Child Branch',
            'parent_id' => $this->parentBranch->id
        ]);

        // Create another branch without children
        $anotherBranch = Branch::create([
            'code' => 'ANOTHER',
            'name' => 'Another Branch'
        ]);

        // Try to delete both the parent branch and another branch
        $response = $this->actingAs($this->user)
            ->post(route('basicdata.branch.deleteMultiple'), [
            'ids' => [$this->parentBranch->id, $anotherBranch->id]
        ]);

        // Assert that the request fails with the expected message
        $response->assertJson([
            'success' => false,
            'message' => 'Beberapa cabang memiliki anak cabang dan tidak dapat dihapus.'
        ]);
        $response->assertStatus(422); // Unprocessable Entity

        // Verify neither branch was deleted
        $this->assertDatabaseHas('branches', [
            'id' => $this->parentBranch->id,
            'deleted_at' => null
        ]);
        $this->assertDatabaseHas('branches', [
            'id' => $anotherBranch->id,
            'deleted_at' => null
        ]);
    }

    #[Test]
    public function branch_has_correct_children_relationship()
    {
        // Create a child branch
        $childBranch = Branch::create([
            'code' => 'CHILD1',
            'name' => 'Child Branch 1',
            'parent_id' => $this->parentBranch->id
        ]);

        // Create another child branch
        $anotherChildBranch = Branch::create([
            'code' => 'CHILD2',
            'name' => 'Child Branch 2',
            'parent_id' => $this->parentBranch->id
        ]);

        // Refresh parent branch
        $this->parentBranch->refresh();

        // Assert that the parent has two children
        $this->assertEquals(2, $this->parentBranch->children()->count());

        // Assert that the children collection contains the two child branches
        $this->assertTrue($this->parentBranch->children->contains($childBranch));
        $this->assertTrue($this->parentBranch->children->contains($anotherChildBranch));
    }
}
