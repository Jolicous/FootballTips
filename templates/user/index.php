<div class="row">
	
	<?php
	if (isset ( $_SESSION ['loggedin'] ) && $_SESSION ['loggedin'] == true) {
		echo "<p>You are logged as " . $_SESSION ['user'] ['email'] . "</p>";
	} else {
		
		?>
		
		<form class="col-12 form-padding" method="post" action="/user/doLogin">
			<label for="email">E-Mail</label>
	  		<input id="email" name="email" type="text" class="form-control" required autofocus>
				
			
			<label class="control-label" for="password">Passwort</label>
			<input id="password" name="password" type="password" class="form-control" required>
				
		<button type="submit" name="send" class="btn btn-primary float-right button-margin">Anmelden</button>
		</form>
		
		
		<?php
	}
	?>
	</div>
<div class="row">	
	<form action="/user/doCreate" method="post" class="col-12 form-padding">
		<div class="form-group">
		  <label for="fname">Vorname</label>
	  	<input id="fname" name="fname" type="text" class="form-control">
		</div>
		<div class="form-group">
		  <label for="lname">Nachname</label>
	  	<input id="lname" name="lname" type="text" class="form-control">
		</div>
		<div class="form-group">
		  <label for="email">E-Mail</label>
	  	<input id="email" name="email" type="text" class="form-control">
		</div>
		<div class="form-group">
			<label class="control-label" for="password">Passwort</label>
			<input id="password" name="password" type="password" class="form-control">
		</div>
		<button type="submit" name="send" class="btn btn-primary float-right">Registrieren</button>
	</form>
</div>
