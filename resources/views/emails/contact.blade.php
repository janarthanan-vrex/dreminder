<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Enquiry</title>
</head>
<body style="font-family:Arial,sans-serif;background:#f8fafc;padding:20px">

    <div style="max-width:600px;margin:auto;background:#ffffff;border-radius:10px;padding:25px">

        <h2 style="margin-bottom:20px;color:#7c3aed">
            New Contact Enquiry
        </h2>

        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse">

            <tr>
                <td style="font-weight:bold;width:160px">First Name</td>
                <td>{{ $data['first_name'] }}</td>
            </tr>

            <tr>
                <td style="font-weight:bold">Last Name</td>
                <td>{{ $data['last_name'] }}</td>
            </tr>

            <tr>
                <td style="font-weight:bold">Email</td>
                <td>{{ $data['email'] }}</td>
            </tr>

            <tr>
                <td style="font-weight:bold">Phone</td>
                <td>{{ $data['phone'] ?: '-' }}</td>
            </tr>

            <tr>
                <td style="font-weight:bold">Subject</td>
                <td>{{ $data['subject'] }}</td>
            </tr>

            <tr>
                <td style="font-weight:bold;vertical-align:top">Message</td>
                <td>
                    {!! nl2br(e($data['message'])) !!}
                </td>
            </tr>

        </table>

    </div>

</body>
</html>