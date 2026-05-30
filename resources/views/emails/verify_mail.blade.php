<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>

<body style="font-family:Arial;background:#f5f5f5;padding:30px">

<div style="max-width:600px;margin:auto;background:#fff;padding:40px;border-radius:12px">

    <h2 style="margin-bottom:20px;color:#111">
        Verify Your Email
    </h2>

    <p style="font-size:15px;color:#555;line-height:1.7">
        Hi {{ $user->first_name }},
    </p>

    <p style="font-size:15px;color:#555;line-height:1.7">
        Please verify your email address by clicking below button.
    </p>

    <a href="{{ $verifyUrl }}"
       style="
            display:inline-block;
            margin-top:20px;
            background:#7c3aed;
            color:#fff;
            text-decoration:none;
            padding:14px 24px;
            border-radius:8px;
            font-weight:600;
       ">
        Verify Email
    </a>

</div>

</body>
</html>