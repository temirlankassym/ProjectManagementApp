@php
    use App\Models\User;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Translators and Chief Editors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        h1 {
            color: #333;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        a {
            color: #333;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        a:hover {
            color: #007BFF;
            text-decoration: underline;
            transform: scale(1.3);
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .navbar {
            background-color: #f8f9fa;
            padding: 10px 20px;
            margin-bottom: 20px;
        }
        .navbar a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .rating-board {
            position: fixed;
            right: 0;
            top: 0;
            width: 300px;
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
            overflow: auto;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        }
        .rating-board h2 {
            margin-bottom: 10px;
        }
        .rating-board-left {
            position: fixed;
            left: 0;
            top: 0;
            width: 300px;
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
            overflow: auto;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .rating-board-left h2 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="/home">Home</a>
</div>
<h1>Translators</h1>
<ul>
    @foreach($translators as $translator)
        <li>
            <a href="/profile/ {{$translator->id}}">
            <img src="{{ $translator->image ?: 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/2048px-Default_pfp.svg.png' }}" alt="{{ $translator->firstname }}">
            </a>
            {{ $translator->firstname }}
        </li>
    @endforeach
</ul>
<h1>Chief editors</h1>
<ul>
    @foreach($chiefs as $chief)
        <li>
            <a href="/profile/ {{$chief->id}}">
            <img src="{{ $chief->image ?: 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/2048px-Default_pfp.svg.png' }}" alt="{{ $chief->firstname }}">
            </a>
            {{ $chief->firstname }}
        </li>
    @endforeach
</ul>
<div class="rating-board">
    <h2>Rating Board</h2>
    <img src="https://cdn-icons-png.flaticon.com/512/3791/3791606.png" alt="">
    <ul>
        @foreach($topTranslated as $translator => $words)
            <li>{{ User::where('email',$translator)->first()->firstname}} have translated {{$words}} words</li>
        @endforeach
    </ul>
</div>
<div class="rating-board-left">
    <h2>Translation mistakes Leaderboard</h2>
    <img src="https://cdn-icons-png.freepik.com/256/9490/9490391.png" alt="">
    <ul>
        @foreach($topMistakes as $user)
            <li>{{ $user->firstname }}: {{ $user->mistakes }} mistakes</li>
        @endforeach
    </ul>
</div>
</body>
</html>
