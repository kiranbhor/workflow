<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class WorkflowSequence extends Model
{
    use Translatable;

    protected $table = 'workflow__workflowsequences';
    public $translatedAttributes = [];
    protected $fillable = [];
}
