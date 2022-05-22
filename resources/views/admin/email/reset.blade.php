<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Create a new password</h1>

		<p>Forgot your password, huh? No big deal.<br>
		To create a new password, just follow this link</p>

		<h2><b><a href="{!! route('auth.password.reset.form', urlencode($code)) !!}">Create a new password</a></b></h2>
		<br>
		Link doesn't work? Copy the following link to your browser address bar:
		<br>{!! route('auth.password.reset.form', urlencode($code)) !!} </p>
		<p>You received this email, because it was requested by a Production user. This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same.</p>
		<p>Thank you,<br>

		The Production Team</p>
	</body>
</html>