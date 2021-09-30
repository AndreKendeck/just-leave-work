<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    /** @test **/
    public function after_migration_the_documents_table_exists()
    {
        $tableExists = Schema::hasTable('documents');
        $this->assertTrue($tableExists);
    }

    /** @test **/
    public function a_document_can_be_created()
    {
        $leave = factory('App\Leave')->create();
        $document = factory('App\Document')->create([
            'documentable_type' => get_class($leave),
            'documentable_id' => $leave->id
        ]);
        $this->assertDatabaseHas('documents', [
            'documentable_type' => $document->documentable_type,
            'documentable_id' => $document->documentable_id,
            'id' => $document->id,
            'name' => $document->name,
            'file_type' => $document->file_type
        ]);
    }

    /** @test  @todo  **/
    public function documents_can_be_added_to_the_payload_when_requesting_leave_()
    {
        Storage::fake(); 
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->make([
            'team_id' => $user->team->id,
            'user_id' => $user->id,
        ]);
        $payload = [
            'documents' => [
                0 => UploadedFile::fake()->create('doctors_letter')
            ],
        ];
        $this->actingAs($user)
        ->post(route('leaves.store') , [
                'reason' => $leave->reason->id,
                'from' => $leave->from->format('Y-m-d'),
                'until' => $leave->until->format('Y-m-d'),
                'halfDay' => $leave->half_day,
                'documents' => ''
        ]); 
    }
}
