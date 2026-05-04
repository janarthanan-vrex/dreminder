<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>

    <p>Click the button below to reset your password:</p>

   <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}">
    Reset Password
</a>

    <p>If you did not request this, ignore this email.</p>
</body>
</html>