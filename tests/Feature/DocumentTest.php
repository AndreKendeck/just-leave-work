<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
}
