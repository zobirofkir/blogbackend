<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Account Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
        }
        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            margin: 10px 0;
        }
        strong {
            font-weight: bold;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
            border-top: 1px solid #dddddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CSW-BLOG</h1>
        <p>Here are your account details:</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>
        <p class="footer">Please keep this information secure. If you need to log in, you can do so by clicking the button below:</p>
    </div>
</body>
</html>
