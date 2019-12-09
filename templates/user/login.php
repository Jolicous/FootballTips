<div class="row">
	
	<?php
	if (isset ( $_SESSION ['loggedin'] ) && $_SESSION ['loggedin'] == true) {
		echo "<p>You are logged as " . $_SESSION ['user'] ['email'] . "</p>";
	} else {
		
		?>
		
		<form class="col-12 form-padding" method="post" action="/user/doLogin">
			<label for="email">E-Mail</label>
	  		<input id="email" name="email" type="email" class="form-control" required autofocus>
				
			
			<label class="control-label" for="password">Passwort</label>
			<input id="password" name="password" type="password" class="form-control" required>
				
		<button type="submit" name="send" class="btn btn-primary float-right button-margin">Anmelden</button>
		</form>
		
		
		<?php
	}
	?>
	</div>