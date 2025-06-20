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
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            background-color: #3498db;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .table-container {
            text-align: left;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .report-table th {
            background-color: #3498db;
            color: white;
        }

        .report-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 15px;
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
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>Upcoming Plan Expirations</h1>
        </div>

        <!-- Content Section -->
        <div class="content">
            <p><strong>This is a reminder that the following plans are expiring soon.</strong></p>
            <div class="table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Company Name</th>
                            <th>Expiration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expiringPlans as $plan)
                        <tr>
                            <td>{{ $plan['user_name'] }}</td>
                            <td>{{ $plan['company'] }}</td>
                            <td>{{ $plan['plan_end_date'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <img src="{{ $message->embed(public_path('assets/img/vlogo.png')) }}" alt="Logo" style="max-width:200px;" />
            <p><strong>Email:</strong> admin@visionworldtech.com</p>
            <p><strong>Website:</strong> <a href="https://www.visionworldtech.com" target="_blank">www.visionworldtech.com</a></p>
            <p>Need help? <a href="javascript:void(0)">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
