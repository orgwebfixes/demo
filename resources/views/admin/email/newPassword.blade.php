<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Your new password on {{Config::get('srtpl.settings.project_title','Production')}}</h1>

		<p>You have changed your password<br>
		Please, keep it in your records so you don't forget it</p>

		<br>
		<p>Your email address {{$email}}
		<br>
		<p>Thank you,<br>
		The {{Config::get('srtpl.settings.project_title','Production')}} Team</p>
	</body>
</html>