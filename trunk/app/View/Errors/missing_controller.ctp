<?php 
	echo $this->Html->script('jquery-1.8.3');
	?>
<script>
$(document).ready(function(){
	var url = "<?php echo $this->webroot;?>";
	window.location.href = url + '/login/logout';
});
</script>