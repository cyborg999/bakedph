    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js" ></script>
    <script type="text/javascript">
	   	function setDefaultDate(){
	   		var now = new Date();

			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);

			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

			var dateInput = $("input[type='date']");

			dateInput.val(today);
	   	}		
	   	
	   	setDefaultDate();
    </script>