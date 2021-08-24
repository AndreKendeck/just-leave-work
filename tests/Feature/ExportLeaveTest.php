<?php

namespace Tests\Feature;

use App\Jobs\DeleteLeaveExportFromStorage;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;

class ExportLeaveTest extends TestCase
{
    /** @test **/
    public function a_admin_can_export_team_leaves()
    {
        Storage::fake();
        Bus::fake();
        $month = rand(1, 12);
        $year = now()->format('Y');
        $admin = factory('App\User')->create();
        $admin->attachRole('team-admin', $admin->team);
        $response = $this->actingAs($admin)
            ->get(route('leaves.export', [
                'month' => $month,
                'year' => $year,
            ]))->assertOk()
            ->assertSessionHasNoErrors()
            ->assertJsonStructure(['message', 'file']);
        $arrayOfPath = explode('/', $response->json(['file']));
        $file = $arrayOfPath[sizeof($arrayOfPath) - 1];
        Storage::assertExists($file);
        Bus::assertDispatched(DeleteLeaveExportFromStorage::class);
    }

    /** @test **/
    public function a_user_cannot_export_team_leaves_for_the_month()
    {
        $month = rand(1, 12);
        $year = now()->format('Y');
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('leaves.export', [
                'month' => $month,
                'year' => $year,
            ]))->assertForbidden();
    }
}
