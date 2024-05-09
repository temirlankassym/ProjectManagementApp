<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #a8c9b9;
            width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #1a202c;
            margin-bottom: 20px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            margin-top: 10px;
        }
        .register-link {
            color: #1a202c;
            text-decoration: none;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="/register" method="post">
        @csrf
        <h1>Register</h1>
        @if(isset($error))
            <div class="error-message">
                {{ $error }}
            </div>
        @endif
        <input type="text" name="firstname" placeholder="First Name" required>
        <input type="text" name="lastname" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="translator">Translator</option>
            <option value="chief">Chief</option>
            <option value="manager">Manager</option>
        </select>
        <button type="submit">Register</button>
    </form>
    <a href="/login" class="register-link">Already have an account? Login</a>
</div>
</body>
</html>
