<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowLog extends Model
{
    use SoftDeletes;

    protected $table = 'workflow__workflowlogs';
    protected $guarded =['id'];
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workflow(){
        return $this->belongsTo('Modules\Workflow\Entities\Workflow','request_workflow_id','id');
    }
}
