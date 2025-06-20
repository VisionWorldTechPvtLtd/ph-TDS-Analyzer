<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borewell Offline Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 20px;
            background: #eef2f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .email-container {
            max-width: 620px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            padding: 30px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 26px;
            letter-spacing: 1px;
        }

        .email-body {
            padding: 30px;
            color: #444;
        }

        .email-body h2 {
            color: #6a11cb;
            font-size: 20px;
            margin-top: 0;
        }

        .email-body p {
            font-size: 16px;
            line-height: 1.7;
            margin: 10px 0;
        }

        .pump-card {
            background: #f4f8ff;
            border-left: 5px solid #6a11cb;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .pump-card p {
            margin: 4px 0;
            font-size: 15px;
        }

        .email-footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .email-footer a {
            color: #2575fc;
            text-decoration: none;
        }

    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-body">
            <h3>{{ $user->company}}</h3>
            <p>We would like to inform you that your borewell is currently <strong style="color:#e74c3c;">offline</strong>
                kindly check your system or contact support if this was not expected.</p>
            @foreach($offlinePumps as $pump)
            <p><strong>Borewell ID:</strong> {{ $pump->id }}</p>
            <p><strong>Name:</strong> {{ $pump->pump_title }}</p>
            @endforeach
            <p>Regards,</p>
            <p>
                Technical Department<br>
                Mobile: +91-7742714000 <br>Complaint:
                <a href="https://docs.google.com/forms/d/e/1FAIpQLScINLkDx3Uh0FI0pXhwe3PvCH7cGTLH-5vMNlgDNHM2E4Drzw/viewform" target="_blank"> Click
                </a>
            </p>

            </a>
        </div>

        <div class="email-footer">
            <img src="{{ asset('assets/img/vlogo.png') }}" alt="Logo" style="max-width:220px;" />
            <p><strong>Email:</strong> <a href="mailto:admin@visionworldtech.com">admin@visionworldtech.com</a></p>
            <p><strong>Website:</strong> <a href="https://www.visionworldtech.com" target="_blank">www.visionworldtech.com</a></p>
            <p>Need help? <a href="https://www.visionworldtech.com/contact" target="_blank">Contact Support</a></p>
        </div>
    </div>

</body>
</html>
