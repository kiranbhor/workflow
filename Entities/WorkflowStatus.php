<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowStatus extends Model
{
    use SoftDeletes;

    protected $table = 'workflow__workflowstatuses';
    public $translatedAttributes = [];

    public $fillable = [
        'status',
        'sequence_no',
        'label_class',
        'is_closing_status',
        'request_type_id',
        'created_by',
        'assign_to_employee',
        'assign_to_designation',
        'assign_to_department',
        'worklow_place'
    ];

    protected $dates = ['deleted_at'];


    public function __toString()
    {
        return $this->status;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestType(){
        return $this->belongsTo(RequestType::class,'request_type_id','id');
    }

}
