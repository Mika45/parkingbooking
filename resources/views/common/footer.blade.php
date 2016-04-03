<div id="footer" class="container-fluid">
        	<div class="container">
	        	<footer>
			    	<div class="row">
			        	<div class="col-lg-12">
			            	<ul class="list-unstyled">
			              		<li><a href="/{{App::getLocale()}}/about">{{Lang::get('site.nav_about')}}</a></li>
								<li><a href="/{{App::getLocale()}}/affiliates">{{Lang::get('site.nav_affiliates')}}</a></li>
			              		<li><a href="/{{App::getLocale()}}/tscs">{{Lang::get('site.nav_tscs')}}</a></li>
			              		<li><a href="/{{App::getLocale()}}/privacy">{{Lang::get('site.nav_privacy')}}</a></li>
			              		<li><a href="/{{App::getLocale()}}/payment-methods">{{Lang::get('site.nav_payment')}}</a></li>
			              		<li class="pull-right">
			              			<a class="btn btn-social-icon btn-twitter" target="_blank" href="https://twitter.com/ParkingLegend">
			              				<i class="fa fa-twitter"></i>
			              			</a>
			              		</li>
			              		<li class="pull-right">
			              			<a class="btn btn-social-icon btn-google" target="_blank" href="https://plus.google.com/+Parkinglegendcom">
			              				<i class="fa fa-google"></i>
			              			</a>
			              		</li>
			              		<li class="pull-right">
			              			<a class="btn btn-social-icon btn-facebook" target="_blank" href="https://www.facebook.com/ParkingLegend.com1">
			              				<i class="fa fa-facebook"></i>
			              			</a>
			              		</li>
			            	</ul>

			            	<p>ParkingLegend.com &copy; {{Lang::get('site.copyright')}}.</p>
			            	@if(isset($card_icons))
			            		@if($card_icons == 'Y')
			            			<br/>
			            			<img src="/img/bank/Visa.jpg" />&nbsp;&nbsp;
			            			<img src="/img/bank/Mastercard.jpg" />&nbsp;&nbsp;
			            			<img src="/img/bank/Maestro.jpg" />&nbsp;&nbsp;
			            			<a href="{{Lang::get('site.secure_link')}}" target="_blank"><img src="/img/bank/vbv.jpg" /></a>&nbsp;&nbsp;
			            			<a href="{{Lang::get('site.secure_link')}}" target="_blank"><img src="/img/bank/sc_62x34.gif" /></a>
			            		@endif
			            	@endif

			          	</div>
			        </div>
		    	</footer>
	    	</div>
	    </div>

    </body>
</html>