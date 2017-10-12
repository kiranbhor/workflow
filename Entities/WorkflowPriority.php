<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowPriority extends Model
{
    use SoftDeletes;

    protected $table = 'workflow__workflowpriorities';
    public $translatedAttributes = [];
    protected $guarded =['id'];
    protected $dates = ['deleted_at'];

}
