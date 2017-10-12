<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    use SoftDeletes;

    protected $table = 'workflow__workflows';
    protected $guarded =['id'];
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestType(){
        return $this->belongsTo('Modules\Workflow\Entities\RequestType','request_type_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(){
        return $this->belongsTo('Modules\Workflow\Entities\WorkflowStatus','request_workflow_status_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestStatus(){
        return $this->belongsTo('Modules\Workflow\Entities\WorkflowStatus','request_status_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedTo(){
        return $this->belongsTo('Modules\User\Entities\Sentinel\User','assigned_to_user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedBy(){
        return $this->belongsTo('Modules\User\Entities\Sentinel\User','requester_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedUser(){
        return $this->assignedTo();
    }



}
