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

/* Framework-agnostic tab switcher for the EN/DE singleton + homepage + service
   + page editors. The admin theme doesn't ship Bootstrap's tab JS, so we wire
   up clicks ourselves. Matches the existing markup:
     <ul class="nav nav-tabs"><li class="nav-item"><a class="nav-link" href="#pane-id">...</a></li></ul>
     <div class="tab-content"><div class="tab-pane" id="pane-id">...</div></div>
*/
document.addEventListener('click', function (e) {
    var link = e.target.closest('.nav-tabs .nav-link');
    if (!link) return;
    var href = link.getAttribute('href') || '';
    if (!href.startsWith('#')) return;
    var pane = document.querySelector(href);
    if (!pane) return;
    e.preventDefault();
    var nav = link.closest('.nav-tabs');
    var content = pane.parentElement;
    nav.querySelectorAll('.nav-link').forEach(function (l) { l.classList.remove('active'); });
    content.querySelectorAll('.tab-pane').forEach(function (p) { p.classList.remove('active', 'show'); });
    link.classList.add('active');
    pane.classList.add('active', 'show');
});

/* Hide non-active panes on first paint so they don't all stack visibly. */
document.querySelectorAll('.tab-content').forEach(function (content) {
    content.querySelectorAll('.tab-pane').forEach(function (pane) {
        if (!pane.classList.contains('active')) {
            pane.style.display = 'none';
        }
    });
});
/* Once a tab is shown via the handler above, ensure its `display` is restored. */
document.addEventListener('click', function (e) {
    var link = e.target.closest('.nav-tabs .nav-link');
    if (!link) return;
    var href = link.getAttribute('href') || '';
    if (!href.startsWith('#')) return;
    var pane = document.querySelector(href);
    if (pane) {
        // Hide all sibling panes, then show this one
        pane.parentElement.querySelectorAll('.tab-pane').forEach(function (p) {
            p.style.display = (p === pane) ? '' : 'none';
        });
    }
});
 </script>