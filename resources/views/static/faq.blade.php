@extends('layout')

@section('sidebar')
    <h1>&nbsp;</h1>
    <img src="/img/faq.png"/>
@stop

@section('content')
<h1>{{ Lang::get('content.faq_heading') }}</h1>
<div class="bs-example">
    <div class="panel-group" id="accordion">
        
        <?php 

            for ($i=1; $i<=12; $i++) { 
                
                echo '<div class="panel panel-default">
                         <div class="panel-heading">
                             <h4 class="panel-title">
                                 <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'">'. Lang::get('content.faq_'.$i.'_title') .'</a>
                             </h4>
                         </div>
                         <div id="collapse'.$i.'" class="panel-collapse collapse">
                             <div class="panel-body">
                                 <p>'. Lang::get('content.faq_'.$i.'_content') .'</p>
                             </div>
                         </div>
                      </div>';
            }

        ?>
        
    </div>
</div>
@stop