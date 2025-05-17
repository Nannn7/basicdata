<?php

namespace Modules\Basicdata\Tests\Feature;

use Tests\TestCase;
use Modules\Basicdata\Models\HolidayCalendar;
use Modules\Usermanagement\Models\User;
use Modules\Usermanagement\Models\Role;
use Modules\Usermanagement\Models\Permission;
use Modules\Usermanagement\Models\PermissionGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class HolidayCalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $adminRole;
    protected $holiday;

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

        // Create a holiday calendar for testing
        $this->holiday = HolidayCalendar::create([
            'date' => '2023-01-01',
            'description' => 'New Year',
            'type' => 'national_holiday'
        ]);
    }

    #[Test]
    public function user_with_permission_can_view_holidays_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.holidaycalendar.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_view_holidays_index()
    {
        // Create a role without permissions
        $role = Role::create(['name' => 'viewer', 'guard_name' => 'web']);

        // Create a user with the viewer role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.holidaycalendar.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_create_holiday()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.holidaycalendar.create'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_create_holiday()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.holidaycalendar.create'));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_store_holiday()
    {
        $holidayData = [
            'date' => '2023-12-25',
            'description' => 'Christmas',
            'type' => 'national_holiday'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('basicdata.holidaycalendar.store'), $holidayData);

        $response->assertRedirect(route('basicdata.holidaycalendar.index'));
        $this->assertDatabaseHas('holiday_calendars', $holidayData);
    }

    #[Test]
    public function user_without_permission_cannot_store_holiday()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $holidayData = [
            'date' => '2023-12-25',
            'description' => 'Christmas',
            'type' => 'national_holiday'
        ];

        $response = $this->actingAs($user)
            ->post(route('basicdata.holidaycalendar.store'), $holidayData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('holiday_calendars', $holidayData);
    }

    #[Test]
    public function user_with_permission_can_edit_holiday()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.holidaycalendar.edit', $this->holiday->id));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_edit_holiday()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.holidaycalendar.edit', $this->holiday->id));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_with_permission_can_update_holiday()
    {
        $updatedData = [
            'date' => '2023-01-01',
            'description' => 'New Year Updated',
            'type' => 'collective_leave'
        ];

        $response = $this->actingAs($this->user)
            ->put(route('basicdata.holidaycalendar.update', $this->holiday->id), $updatedData);

        $response->assertRedirect(route('basicdata.holidaycalendar.index'));
        $this->assertDatabaseHas('holiday_calendars', $updatedData);
    }

    #[Test]
    public function user_without_permission_cannot_update_holiday()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $updatedData = [
            'date' => '2023-01-01',
            'description' => 'New Year Updated',
            'type' => 'collective_leave'
        ];

        $response = $this->actingAs($user)
            ->put(route('basicdata.holidaycalendar.update', $this->holiday->id), $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('holiday_calendars', $updatedData);
    }

    #[Test]
    public function user_with_permission_can_delete_holiday()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('basicdata.holidaycalendar.destroy', $this->holiday->id));

        $response->assertRedirect(route('basicdata.holidaycalendar.index'));
        $this->assertSoftDeleted($this->holiday);
    }

    #[Test]
    public function user_without_permission_cannot_delete_holiday()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->delete(route('basicdata.holidaycalendar.destroy', $this->holiday->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('holiday_calendars', ['id' => $this->holiday->id, 'deleted_at' => null]);
    }

    #[Test]
    public function user_with_permission_can_export_holidays()
    {
        $response = $this->actingAs($this->user)
            ->get(route('basicdata.holidaycalendar.export'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_without_permission_cannot_export_holidays()
    {
        // Create a role with only read permission
        $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $role->givePermissionTo('basic-data.read');

        // Create a user with the reader role
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('basicdata.holidaycalendar.export'));

        $response->assertStatus(403);
    }
}
