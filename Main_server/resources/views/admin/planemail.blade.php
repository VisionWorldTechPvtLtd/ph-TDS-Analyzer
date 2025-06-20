<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            width: 100%;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-spacing: 0;
            width: 100%;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #3498db;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .content {
            padding: 20px 40px;
            text-align: center;
            color: #333333;
        }

        .content h2 {
            font-size: 22px;
            margin: 20px 0 10px;
            color: #333333;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .details {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            text-align: left;
        }

        .details p {
            margin: 5px 0;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            margin: 20px 0;
            background-color: #f39c12;
            background-image: linear-gradient(135deg, #f39c12, #e74c3c);
            color: #ffffff;
            font-size: 18px;
            text-decoration: none;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .footer {
            background-color: #333333;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #f39c12;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <table role="presentation" class="container">
        <tr>
            <td>
                <table role="presentation" width="100%" class="header">
                    <tr>
                        <td>
                            <h1>Your Plan is Expiring Soon</h1>
                        </td>
                    </tr>
                </table>
                <table role="presentation" width="100%" class="content">
                    <tr>
                        <td>
                            <h2>Hello {{$user->first_name}},</h2>
                            <p>We hope you're enjoying our services. This is a friendly reminder that your current plan is set to expire on <strong>{{$pump->plan_end_date->format('F d, Y')}}</strong>. We don't want you to miss out on all the benefits you love.</p>

                            @foreach($user->pumps->filter(function($pump) {
                            return $pump->plan_end_date->diffInDays(now()) <= 30; }) as $pump) <div class="details">
                                <p><strong>Pump Name: </strong> {{$pump->pump_title}}</p>
                                <p><strong>Pump Location: </strong> {{$pump->address}}</p>
                                <p><strong>Expiration Date: </strong> {{$pump->plan_end_date->format('F d, Y')}}</p>
                                </div>
                                @endforeach
                                <a href="{{url('http://visioncgwa.com/')}}" class="cta-button">Renew Your Plan Now</a>
                        </td>
                    </tr>
                </table>
                <!-- Footer Section -->
                <table role="presentation" width="100%" class="footer">
                    <tr>
                        <td>
                            <img src="{{ $message->embed(public_path('assets/img/vlogo.png')) }}" alt="Logo" style="max-width:220px;" />
                            <p><i class="fa-regular fa-envelope"></i> <span class="ps-3"><strong>Email:</strong> admin@visionworldtech.com </span></p>
                            <span class="ps-3">
                                <strong>Website:</strong>
                                <a href="https://www.visionworldtech.com" target="_blank" style="text-decoration: none; color: #0d6efd;">www.visionworldtech.com</a>
                            </span>
                            <p>Need help? <a href="javascript:void(0)">Contact Support</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
