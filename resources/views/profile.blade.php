<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }
        .profile-details {
            flex: 1;
        }
        .profile-details h2 {
            margin-bottom: 10px;
        }
        .profile-details p {
            margin-bottom: 8px;
        }
        .button-container {
            text-align: center;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<!-- The Modal -->
<div id="editProfileModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="profileForm" method="POST" action="/profile" enctype="multipart/form-data">
            @csrf
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="{{ auth()->user()->firstname }}" required><br>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="{{ auth()->user()->lastname }}" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required><br>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image"><br>
            <input type="submit" value="Update Profile">
        </form>
    </div>
</div>

<div class="container">
    <h1>User Profile</h1>
    <a href="/home">Home</a>
    <div class="profile-info">
        <img src="{{ auth()->user()->image}}" alt="Profile Picture">
        <div class="profile-details">
            <h2>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h2>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
            <p><strong>Joined:</strong> {{ date('M d, Y', strtotime(auth()->user()->created_at)) }}</p>
        </div>
    </div>
    <div class="button-container">
        <button id="editProfileButton">Edit Profile</button>
        <button onclick="logout()">Logout</button>
    </div>
</div>

<script>
    var editProfileModal = document.getElementById("editProfileModal");
    var editProfileButton = document.getElementById("editProfileButton");
    var close = document.getElementsByClassName("close")[0];

    editProfileButton.onclick = function() {
        editProfileModal.style.display = "block";
    }

    close.onclick = function() {
        editProfileModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == editProfileModal) {
            editProfileModal.style.display = "none";
        }
    }
</script>
<script>
    function logout() {
        window.location.href = "/logout";
    }
</script>
</body>
</html>
