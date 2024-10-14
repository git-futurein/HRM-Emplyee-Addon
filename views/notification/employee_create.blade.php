<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }

        .password {
            font-weight: bold;
            color: #d9534f;
            /* Bootstrap Danger color for visibility */
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Welcome to the Team, {{ $user->name }}!</h1>
        <p>We’re thrilled to have you join us at <strong>{{ env('APP_NAME') }}</strong> as our new <strong>[Job
                Title]</strong>.</p>

        <h2>Your First Day</h2>
        <p>You’ll be starting on <strong>{{ $employee->join_date }}</strong>.</p>

        <h2>Meet Your Team</h2>
        <p>Your team members are eager to meet you and will be excited to show you around!</p>

        <h2>Your Account Information</h2>
        <p>Your email is: <span class="password">{{ $employee->email }}</span></p>
        <p>Your temporary password is: <span class="password">{{ $password }}</span></p>
        <p>Please change this password upon your first login to ensure your account's security.</p>

        <p>If you have any questions before your start date, feel free to reach out to me at
            <strong>{{ env('MAIL_FROM_ADDRESS') }}</strong> or
            <strong>[Your Phone Number]</strong>.
        </p>

        <p>Once again, welcome to <strong>{{ env('APP_NAME') }}</strong>! We look forward to a great journey together.
        </p>

        <div class="footer">
            <p>Best regards,<br>Pervez<br>CEO<br>{{ env('APP_NAME') }}</p>
        </div>
    </div>

</body>

</html>
