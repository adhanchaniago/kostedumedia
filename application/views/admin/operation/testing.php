<?php

/**
 * @author Wira Sakti G
 * @added Apr 18, 2013
 */
?>
<script>
$(document).ready(function() {
	// validate signup form on keyup and submit
	$("#operationAdd").validate({
		rules: {
			firstname: "required"
		},
		messages: {
			firstname: "Please enter your firstnaasdfme"
		}
	});

});
</script>

</head>
<body>

<form id="operationAdd" method="post" action="">
		<p>
			<label for="firstname">Firstname</label>
			<input id="firstname" name="firstname" type="text" />
		</p>
		<p>
			<input type="submit" value="Submit"/>
		</p>
</form>

</body>
</html>