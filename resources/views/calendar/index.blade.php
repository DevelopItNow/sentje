@extends('layouts.app')
@section('content')
    <div class="panel panel-primary">
        <div class="panel-body">
            <?php
            $calendar->setId('calendar');
            ?>
            {!! $calendar->calendar() !!}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale-all.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#calendar-calendar').fullCalendar({
                header: {
                    left: 'month',
                    center: 'title',
                    right : 'today, prevYear, prev, next, nextYear'
                },
                @if(Config::get('app.locale') == 'nl')
                    locale: 'nl',
                @else
                    locale: 'en',
                @endif
                fixedWeekCount: false,
                editable: false,
                handleWindowResize: true,
                weekends: true, // Hide weekends
                displayEventTime: true,
            });
        });
    </script>
@endsection