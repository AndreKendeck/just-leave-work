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
            'file_type' => $document->file_type, 
            'size' => $document->size
        ]);
    }

    public function a_document_can_be_added_to_leave()
    {
        Storage::fake();
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
            'user_id' => $user->id,
        ]);
        $document = UploadedFile::fake()->create('doctors_letter', 200, 'application/pdf');
        $this->actingAs($user)
            ->post(route('documents.store'), [
                'document' => $document,
                'model' => 'leave',
                'id' => $leave->id
            ])
            ->assertSessionDoesntHaveErrors()
            ->assertCreated()
            ->assertJsonStructure(['message']);
        $this->assertDatabaseHas('documents', [
            'documentable_type' => get_class($leave),
            'documentable_id' => $leave->id,
            'file_type' => $document->getType(),
            'size' => $document->getSize(),
            'name' => $document->hashName()
        ]);
    }
}
