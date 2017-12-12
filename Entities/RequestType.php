<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestType extends Model
{
    use SoftDeletes;

    protected $table = 'workflow__requesttypes';
    public $translatedAttributes = [];
    protected $fillable =[
        'type',
        'parent_request_id',
        'sequence_no',
        'description',
        'default_assignee_user_id',
        'default_designation_id',
        'default_dept_id',
        'notification_group_id',
        'validity_days',
        'additional_emails_to_notify',
        'notify_to_supervisor',
        'initial_request_status_id',
        'assign_to_supervisor',
        'send_email_notification',
        'update_request_route',
        'create_request_route',
        'repository',
        'show_close_btn',
        'details_view',
        'show_approve_btn',
        'show_reject_btn',
        'show_forward_btn',
        'show_cancel_btn',
        'created_by'
    ];
    protected $dates = ['deleted_at'];


    public  function __toString()
    {
        return $this->type;
    }

    /**
     * Parent request of the current request
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentRequest(){
        return $this->hasOne('Modules\Workflow\Entities\RequestType','parent_request_id','id');
    }

    /**
     * Get all child request of the cuerrent request
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childRequest(){
        return $this->hasMany('Modules\Workflow\Entities\RequestType','parent_request_id','id');
    }

    /**
     * Return statuses of the request
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function status(){
        return $this->hasMany(WorkflowStatus::class,'request_type_id','id');
    }

}
