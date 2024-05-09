<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-image: url('https://wallpapers.com/images/hd/hd-material-background-ft6x9nw20xof6byf.jpg');
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .projects {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .project-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: calc(33% - 20px);
            min-width: 250px;
        }

        .project-card h2 {
            color: #007bff;
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .progress-bar {
            height: 8px;
            background-color: #ddd;
            border-radius: 5px;
            margin: 10px 0;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            width: 50%;
            background-color: #007bff;
            transition: width 0.3s ease;
        }

        .due-date {
            font-style: italic;
            color: #666;
        }

        .more-info {
            color: #007bff;
            text-decoration: none;
        }

        .create-project {
            margin-top: 30px;
            text-align: center;
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
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 400px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .user-profile {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .user-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #007bff;
            transition: transform 0.3s ease;
        }

        .user-image:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
<header>
    <div class="header-content">
        <h1>Projects Dashboard</h1>
        <nav>
            <a href="/logout">Logout</a>
        </nav>
    </div>
    <div class="user-profile">
        <a href="/profile">
            <img src="{{ auth()->user()->image ? auth()->user()->image : 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/2048px-Default_pfp.svg.png' }}" alt="User Image" class="user-image">
        </a>
    </div>
</header>


<main class="container">
    <div class="projects">
        @foreach($projects as $project)
            <div class="project-card">
                <h2>{{ $project->name }}</h2>
                <p>{{ $project->description }}</p>
                <div class="progress-bar">
                    <div class="progress" style="width: {{ $project->progress }}%;"></div>
                </div>
                <h1>{{$project->progress}}</h1>
                <p class="due-date">Due: {{ date('M d, Y', strtotime($project->due_date)) }}</p>
                <a href="/projects/{{ $project->id }}" class="more-info">More Info</a>
            </div>
        @endforeach
    </div>

    @if(auth()->user()->role == 'manager')
        <div class="create-project">
            <button id="createProjectButton">Create New Project</button>
        </div>
    @endif

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="projectForm" method="POST" action="/create">
                @csrf
                <input type="text" id="name" name="name" placeholder="Project Name" required>
                <input type="text" id="description" name="description" placeholder="Project Description" required>
                <input type="number" id="words_count" name="words_count" placeholder="Project Word Count" required>
                <input type="date" id="due_date" name="due_date" required>
                <input type="submit" value="Create Project">
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("createProjectButton");
        var span = document.getElementsByClassName("close")[0];

        // Open the modal when the button is clicked
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Close the modal when the close button is clicked
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside the modal content
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });

</script>
</body>
</html>
