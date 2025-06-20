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

        .attributes_item {
            padding: 8px 0;
        }

        .attributes {
            margin: 0 0 21px;
        }

        .attributes_content {
            background-color: #F4F4F7;
            padding: 16px;
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
                            <h1>Welcome To V-Scada</h1>
                        </td>
                    </tr>
                </table>
                <table role="presentation" width="100%" class="content">
                    <tr>
                        <td class="email-body" width="570" cellpadding="0" cellspacing="0">
                            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        <div class="f-fallback">
                                            <h1>Welcome {{ $customer->first_name }} {{ $customer->last_name }}!</h1>
                                            <p>Thanks for Signing Up. We’re thrilled to have you on board. To get the most out of VI Scada, login to your Dashboard:</p>
                                            <!-- Action -->
                                            <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td align="center">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                            <tr>
                                                                <td align="center">
                                                                    <a href="http://visioncgwa.com/" class="cta-button">Login</a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td class="attributes_content">
                                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        <strong>Login Page:</strong><a href="http://visioncgwa.com/">http://visioncgwa.com/</a>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        <strong>User Name: {{ $customer->email }}</strong>
                                                                    </span>
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        <strong>Password: {{ strtok($customer->company, ' ') }}@123</strong>
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p>If you have any questions, feel free to <a href="mailto:admin@visionworldtech.com">email our customer success team</a>.</p>
                                            <!-- Footer Section -->
                                            <table role="presentation" width="100%" class="footer">
                                                <tr>
                                                    <td>
                                                        <img src="{{ $message->embed(public_path('assets/img/vlogo.png')) }}" alt="Logo" style="max-width:220px;" />
                                                        <p><i class="fa-regular fa-envelope"></i> <span class="ps-3"><strong></strong> admin@visionworldtech.com </span></p>
                                                        <span class="ps-3">
                                                            <strong></strong>
                                                            <a href="https://www.visionworldtech.com" target="_blank" style="text-decoration: none; color: #0d6efd;">www.visionworldtech.com</a>
                                                        </span>
                                                        <p>Need help? <a href="javascript:void(0)">Contact Support</a></p>
                                                    </td>
                                                </tr>
                                            </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
