<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #007bff;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        a {
            font-size: 16px;
            color: #28a745;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your blog "{{ $blog->title }}" has been created successfully!</h1>
        <p>You can view your blog at the following link:</p>
        <a href="{{ url('api/blogs/' . $blog->slug) }}">{{ url('/blogs/' . $blog->slug) }}</a>
    </div>
</body>
</html>
