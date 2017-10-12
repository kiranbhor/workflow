    <!-- Modal -->

<div class="modal-dialog modal-danger">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('core::core.modal.title') }}</h4>
        </div>
        <div class="modal-body">
        <input type="hidden" id="workflow_id" value="{{$workflow->id}}" name="workflow_id" >
            {{ trans('core::core.modal.confirmation-message') }}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}</button>
            
            <button type="submit" class="btn btn-outline btn-flat modal-delete-workflow" onClick="bindDeleteEvent()"><i class="glyphicon glyphicon-trash"></i> {{ trans('core::core.button.delete') }}</button>
            
        </div>
    </div>
</div>

<script type="text/javascript">

    function bindDeleteEvent() {
        $.ajax({
            type: 'DELETE',
            url: '{{ URL::route('admin.workflow.workflow.destroy',$workflow->id)}}',
            data:{
                workflow_id :$('#workflow_id').val(),
               _token:$('meta[name="token"]').attr('value'),
            },
            success: function(data) {
                swal("","Request is deleted successfully");
                $('#commonModal').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Oops.","Something went wrong, Please try again","error");
            }
        });
    }
</script>

