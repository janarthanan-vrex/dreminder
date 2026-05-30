<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,sans-serif;">

<div style="max-width:650px;margin:40px auto;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 4px 18px rgba(0,0,0,0.08);">

    <div style="background:#7c3aed;padding:24px;text-align:center;">

        <h2 style="color:#ffffff;margin:0;font-size:24px;">
            Feedback Reply
        </h2>

    </div>

    <div style="padding:30px;">

        <p style="font-size:15px;color:#444;line-height:1.7;">
            Hi <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,
        </p>

        <p style="font-size:15px;color:#444;line-height:1.7;">
            We have reviewed your feedback and replied below.
        </p>

        <div style="margin-top:20px;margin-bottom:20px;">

            <div style="font-size:14px;font-weight:700;color:#111;margin-bottom:8px;">
                Subject
            </div>

            <div style="background:#f8fafc;padding:14px;border-radius:10px;color:#444;font-size:14px;border:1px solid #e2e8f0;">
                {{ $subject }}
            </div>

        </div>

        <div style="margin-top:20px;margin-bottom:20px;">

            <div style="font-size:14px;font-weight:700;color:#111;margin-bottom:8px;">
                Your Message
            </div>

            <div style="background:#f8fafc;padding:16px;border-radius:10px;color:#555;font-size:14px;line-height:1.7;border:1px solid #e2e8f0;">
                {{ $feedback->message }}
            </div>

        </div>

        <div style="margin-top:20px;">

            <div style="font-size:14px;font-weight:700;color:#111;margin-bottom:8px;">
                Admin Reply
            </div>

            <div style="background:#f3e8ff;padding:16px;border-radius:10px;color:#444;font-size:14px;line-height:1.7;border:1px solid #d8b4fe;">
                {{ $reply }}
            </div>

        </div>


    </div>

</div>

</body>
</html>