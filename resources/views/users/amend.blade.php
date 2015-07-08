@extends('booklayout')

@section('content')

	<div class="well">
		<legend>
			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          	<span class="glyphicon-class">{{ Lang::get('site.amend_heading') }}</span>
		</legend>
		<!--{!! Form::open(['url' => '/results', 'id' => 'search']) !!}-->
		
		{!! Form::model($booking, ['action' => ['UsersController@postAmendBooking', $booking->booking_id], 'id' => 'search']) !!}
			@include('forms.change')
		{!! Form::close() !!}
	</div>

@stop


@section('sidebar-right')	
	@if ($cancellations == 'Y')
		<a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#basicModal">{{ Lang::get('site.back_book_cancel_btn') }}</a>
		<br/>
		<br/>
	@endif
	@if (Session::get('reason') == 'TOO_LATE')
		<div class="alert alert-dismissible alert-danger">
		  	<button type="button" class="close" data-dismiss="alert">×</button>
		  	{!! Lang::get('site.info_too_late') !!}
		</div>
	@endif

   	<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		            <h4 class="modal-title" id="myModalLabel">{{ Lang::get('site.amend_cancel_heading') }}</h4>
	            </div>
	            <div class="modal-body">
	                <p>{{ Lang::get('site.amend_cancel_body') }}</p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('site.amend_cancel_btn_no') }}</button>
	                <a href="/mybookings/{{ $booking->booking_id }}/amend/cancel" class="btn btn-primary">{{ Lang::get('site.amend_cancel_btn_yes') }}</a>
	        	</div>
	    </div>
	  </div>
	</div>

@stop