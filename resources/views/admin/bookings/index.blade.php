@extends('templates.admin')

@section('content')

<div class="row">
   <div class="col-xs-12">
     	<div class="box">
			@if (isset($box_title))
			<div class="box-header">
         	<h3 class="box-title">{{ $box_title or null }}</h3>
       	</div><!-- /.box-header -->
       	@endif
			<div class="box-body">
				<table id="bookings" class="table table-bordered table-hover">
					<thead>
						<tr>
						  	<th><small>Booking reference</small></th>
						  	<th><small>Parking name</small></th>
						  	<th><small>Drop-Off date/time</small></th>
						  	<th><small>Pick-Up date/time</small></th>
						  	<th><small>Number plate</small></th>
						  	<th><small>Price</small></th>
						  	<th><small>Name</small></th>
                            <th><small>Mobile</small></th>
						  	<th><small>E-mail</small></th>
						  	<th><small>Status</small></th>
						  	<th><small>Booked at</small></th>
						  	<th><small>Referrer</small></th>
						</tr>
					</thead>
					<tbody>
				  	@foreach ($bookings as $booking)
						<tr>
							<td><small><strong>{{ $booking->booking_ref }}</strong></small></td>
							<td><small>{{ $booking->parking_name }}</small></td>
							<td><small>{{ $booking->checkin }}</small></td>
							<td><small>{{ $booking->checkout }}</small></td>
							<td><small>{{ $booking->car_reg }}</small></td>
							<td><small>{{ $booking->price }}</small></td>
							<td><small>{{ $booking->firstname }} {{ $booking->lastname }}</small></td>
							<td><small>(+{{ $booking->phone_code }}) {{ $booking->mobile }}</small></td>
							<td><small>{{ $booking->email }}</small></td>
							<td><small>{{ $booking->status_descr }}</small></td>
							<td><small>{{ $booking->created_at }}</small></td>
							<td><small>{{ $booking->referrer }}</small></td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@stop

@section('plugins')
	<!-- Datatabels -->
	{!! HTML::script('js/admin/jquery.dataTables.min.js') !!}
	{!! HTML::script('js/admin/dataTables.bootstrap.min.js') !!}
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/bs/dt-1.10.10/datatables.min.css"/>
	@parent
@stop

@section('javascript')
    <script>
      $(document).ready(function() {
          $('#bookings').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
          });
      } );
    </script>
    @parent
@stop
