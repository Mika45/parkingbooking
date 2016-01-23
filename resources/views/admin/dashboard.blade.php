@extends('templates.admin')

@section('content')

<div class="row">
	<div class="col-lg-3 col-xs-6">
	  <!-- small box -->
	  <div class="small-box bg-aqua">
	    <div class="inner">
	      <h3>{{ $stats['countTodayBookings'] }}</h3>
	      <p>Bookings Today</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-bag"></i>
	    </div>
	    <a href="/admin/bookings" class="small-box-footer">Go to Bookings <i class="fa fa-arrow-circle-right"></i></a>
	  </div>
	</div><!-- ./col -->
</row>

@stop