
<div class="row-fluid">
  <div class="span12" style="text-align:center;">
    <?php


			// Report errors to the user


			Alert(GetAlert('error'));


			Alert(GetAlert('success'),'success');


		?>
        
        <img src="<?=ADDRESS?>images/alert_demo.png" />
  </div>
</div>
<style>


/*Colored Label Attributes*/


.label {


    background-color: #BFBFBF;


    border-bottom-left-radius: 3px;


    border-bottom-right-radius: 3px;


    border-top-left-radius: 3px;


    border-top-right-radius: 3px;


    color: #FFFFFF;


    font-size: 9.75px;


    font-weight: bold;


    padding-bottom: 2px;


    padding-left: 4px;


    padding-right: 4px;


    padding-top: 2px;


    text-transform: uppercase;


    white-space: nowrap;


}





.label:hover {


	opacity: 80;


}





.label.success {


    background-color: #46A546;


}


.label.success2 {


    background-color: #CCC;


}


.label.success3 {


    background-color: #61a4e4;


	


}





.label.warning {


    background-color: #FC9207;


}





.label.failure {


    background-color: #D32B26;


}





.label.alert {


    background-color: #33BFF7;


}





.label.good-job {


    background-color: #9C41C6;


}

</style>
