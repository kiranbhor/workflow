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
    protected $guarded =['id'];
    protected $dates = ['deleted_at'];

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
}
