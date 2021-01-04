 <div class="row  preloader hidden">
 	<div class="col-sm">
 		 <button class="btn btn-primary" type="button" disabled>
		    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
		    Loading...
		  </button>
 	</div>
 </div>

  <script type="text/javascript">
 	function hidePreloader(){
		setTimeout(function(){
		$(".preloader").addClass("hidden");
		}, 200);
 	}

 	function showPreloader(){
		$(".preloader").removeClass("hidden");
 	}


 </script>