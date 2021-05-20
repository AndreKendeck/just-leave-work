<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'leaveId' => $this->leave_id,
            'text' => $this->text,
            'wasEdited' => $this->was_edited,
            'canEdit' => $this->can_edit,
            'isDeletable' => $this->is_deletable,
            'isEditable' => $this->is_editable,
            'user' => $this->user,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
