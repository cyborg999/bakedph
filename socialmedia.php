<?php include_once "./head.php"; ?>
<body>
<?php include_once "./spinner.php"; ?>
	<div class="container-sm">
		<?php include_once "./admindashboardnav.php"; ?>
		<div class="row">
			<br>
			<div class="col-sm-3">
				<?php $active = "settings";  include_once "./adminsidenav.php"; ?>
			</div>
			<div class="col-sm-9">
				<?php
					$socials = $model->getAllSocial();

				?>
				<div class="row">
					<div class="col-sm">
						<br>
						<h5>Social Media</h5>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<table class="table">
							<thead>
								<tr>
									<th>Social Media</th>
									<th>Link</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr id="start">
									<td>
										<input type="text" class="form-control name" name="name" required placeholder="Social Media...">
									</td>
									<td>
										<input required type="text" class="form-control link" name="link" placeholder="Link...">
									</td>
									<td>
										<input type="submit" id="add" class="btn  btn-success" value="Add">
									</td>
								</tr>
								
								<?php foreach($socials as $idx => $s): ?>
								<tr>
									<td><?= $s['social'];?></td>
									<td><a target="_blank" href="<?= $s['link'];?>"><?= $s['link'];?></a></td>
									<td>
										<a href="" data-id="<?= $s['id'];?>" class="btn btn-danger btn-sm remove">remove</a>
									</td>
								</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/html" id="tpl">
		<tr>
			<td>
				[SOCIAL]
			</td>
			<td>
				<a href="[LINK]">[LINK]</a>
			</td>
			<td>
				<a href="" data-id="[ID]" class="btn btn-danger btn-sm remove">remove</a>
			</td>
		</tr>
	</script>
	<?php include_once "./foot.php"; ?>
		<script type="text/javascript">
    	(function($){
    		function __listen(){
    			$(".remove").off().on("click", function(e){
    				e.preventDefault();

    				var me = $(this);

    				showPreloader();

    				$.ajax({
    					url  : "ajax.php",
    					data : { removeSocial: true, id : me.data("id") },
    					type : "post",
    					dataType : "json",
    					success : function(response){
							me.parents("tr").remove();

	    					hidePreloader();
    					},
    					complete : function(){
	    					hidePreloader();
    					}
    				});

    			});
    		}

    		__listen();

    		$("#add").on("click", function(e){
    			e.preventDefault();

    			var me = $(this);
    			var tr = me.parents("tr");
    			var tpl = $("#tpl").html();

    			tpl = tpl.replace("[SOCIAL]", tr.find(".name").val()).
    				replace("[LINK]", tr.find(".link").val()).
    				replace("[LINK]", tr.find(".link").val());

    			if(tr.find(".name").val() == ""){
    				alert("Please enter a social media");
    			} else {
	    			if(tr.find(".link").val() == ""){
	    				alert("Please enter a link");	
	    			} else {
	    				showPreloader();

	    				$.ajax({
	    					url  : "ajax.php",
	    					data : { addSocial: true, name : tr.find(".name").val(), link : tr.find(".link").val() },
	    					type : "post",
	    					dataType : "json",
	    					success : function(response){
	    						tpl = tpl.replace("[ID]", response.id);

		    					$("#start").after(tpl);

		    					__listen();

		    					hidePreloader();
	    					},
	    					complete : function(){
		    					hidePreloader();
		    					tr.find(".form-control").val("");
	    					}
	    				});
	    			}
    			}
    		});
    	})(jQuery);
    </script>
</body>
</html>