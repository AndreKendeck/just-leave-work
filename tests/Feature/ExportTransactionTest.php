<?php

namespace Tests\Feature;

use App\Jobs\DeleteExportFileFromStorage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExportTransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_admin_can_export_leave()
    {
        Bus::fake();
        Storage::fake();
        // dont forget to add the user to the team to make it fair
        $user = factory('App\User')->create();
        $user->attachRole('team-admin', $user->team);
        $response = $this->actingAs($user)
            ->get(route('transactions.export', [
                'user' => $user->id,
                'month' => rand(0, 11),
                'year' => '2021',
            ]))->assertOk()
            ->assertJsonStructure(['file']);
        $arrayOfPath = explode('/', $response->json(['file']));
        $file = $arrayOfPath[sizeof($arrayOfPath) - 1];
        Storage::assertExists($file);
        Bus::assertDispatched(DeleteExportFileFromStorage::class);

    }
}
