<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Brexis\LaravelWorkflow\Traits\WorkflowTrait;
use Modules\Master\Entities\Department;
use Modules\Master\Entities\Designation;

class Workflow extends Model
{
    use SoftDeletes,WorkflowTrait;

    protected $table = 'workflow__workflows';
    protected $fillable = [
        'request_type_id',
        'status',
        'sequence_no',
        'label_class',
        'is_closing_status',
        'created_by'
    ];

    protected $casts = [
        'currentPlace' => 'json'
    ];
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedDepartment(){
       return $this->belongsTo(Department::class,'assigned_to_department_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedDesignation(){
        return $this->belongsTo(Designation::class,'assigned_to_designation_id','id');
    }



}
