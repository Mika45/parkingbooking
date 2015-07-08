<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<markers>
	@foreach ($parks as $park)
  		<marker name= "{{$park->parking_name}}" lat="{{$park->lat}}" lng="{{$park->lng}}"/>
  	@endforeach
</markers>