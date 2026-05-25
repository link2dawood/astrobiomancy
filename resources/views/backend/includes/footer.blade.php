<script>
var sidebaropen=1;
 $('.button-click-sidebar').on('click',function(){
	 
	if(sidebaropen==1){
		$('.sidebar').hide();
		$('main').css('paddingLeft',"0px")
		sidebaropen=0;
	}else{
		$('.sidebar').show();
		$('main').css('paddingLeft',"260px")
		sidebaropen=1;
	}
 });

 var jobblinking = '1';
 setInterval(function(){ 
 	if (jobblinking==="1") {
	 	$('.jobblinking').hide('slow');
 		jobblinking = "0";

 	}else if (jobblinking==="0") {
	 	$('.jobblinking').show('slow');
 		jobblinking = "1";
 	}
  }, 1000);

 </script>