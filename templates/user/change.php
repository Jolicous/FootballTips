

<div class="row">
	<form action="/user/doChange" method="post" class="col-12 form-padding">
		<div class="form-group">
		<input id="fname" name="id" type="hidden" value="<?=$user->id?>"> 			
		  <label for="fname">Vorname</label>
	  	<input id="fname" name="fname" type="text" class="form-control" value="<?=$user->firstName?>"> 
		</div>
		<div class="form-group">
		  <label for="lname">Nachname</label>
	  	<input id="lname" name="lname" type="text" class="form-control" value="<?=$user->lastName?>">
		</div>
		<div class="form-group">
		  <label for="email">E-Mail</label>
	  	<input id="email" name="email" type="email" class="form-control" value="<?=$user->email?>">
		</div>
		<div class="form-group">
			<label class="control-label" for="password">Passwort</label>
			<input id="password" name="password" type="password" class="form-control">
		</div>
		<button type="submit" name="change" class="btn btn-primary float-right">Ändern</button>
		<button type="submit" name="logout" class="btn btn-primary float-right button-logout-margin">Logout</button>
	</form>

</div>
