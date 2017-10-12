<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success taskNotificationsCounter animated">{{ $taskNotifications->count() }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <div class="slimScrollDiv">
                <ul class="menu notifications-list">
                    <?php if ($taskNotifications->count() === 0): ?>
                    <li class="noNotifications">
                        <a href="#">
                            {{ trans('notification::messages.no taskNotification') }}
                        </a>
                    </li>
                    <?php endif;?>
                    <?php foreach ($taskNotifications as $notification): ?>
                    <li>
                        <a href="{{ $notification->link }}">
                            <div class="pull-left notificationIcon">
                                <i class="{{ $notification->icon_class }}"></i>
                            </div>
                            <h4>
                                {{ $notification->title }}
                                <small>
                                    <i class="fa fa-clock-o"></i> {{ $notification->time_ago }}
                                    <i class="fa fa-close removeTaskNotification" data-id="{{ $notification->id }}"></i>
                                </small>
                            </h4>
                            <p>{{ $notification->message }}</p>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <li class="footer"><a href="{{ route('admin.notification.notification.index') }}">View all</a></li>
        </li>
    </ul>
</li>

<script>
    $( document ).ready(function() {
        $('.removeTaskNotification').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var self = this;
            $.ajax({
                type: 'POST',
                url: '{{ route('api.notification.read') }}',
                data: {
                    'id': $(this).data('id'),
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.updated) {
                        var notification = $(self).closest('li');
                        notification.addClass('animated fadeOut');
                        setTimeout(function() {
                            notification.remove();
                        }, 510)
                        var count = parseInt($('.taskNotificationsCounter').text());
                        $('.taskNotificationsCounter').text(count - 1);
                    }
                }
            });
        });
    });
</script>
