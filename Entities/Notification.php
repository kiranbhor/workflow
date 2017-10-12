<?php

namespace Modules\Workflow\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $table = 'workflow__notifications';
    public $translatedAttributes = [];
    protected $guarded =['id'];
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestType(){
        return $this->belongsTo('Modules\Workflow\Entities\RequestType', 'request_type_id', 'id');
    }



}
