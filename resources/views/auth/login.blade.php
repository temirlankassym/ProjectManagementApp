<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 300px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #666;
            font-size: 16px;
            text-align: left;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            margin-top: 10px;
            text-align: left;
        }
        .register-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>
<body>
<h1>Login</h1>
@if(isset($error))
    <div class="error-message">
        {{ $error }}
    </div>
@endif
<form method="POST" action="/login">
    @csrf

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Login</button>
</form>

<a href="/register" class="register-link">Don't have an account? Register</a>
</body>
</html>
