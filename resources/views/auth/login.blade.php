<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Autentikasi Pengguna</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="">
</head>
<body>
 <div class="container">
        <div class="login-box">
            <h1>Autentikasi Pengguna</h1>
            
<form method="POST" action="{{ route('login.process') }}">
    @csrf

    <div class="form-group">
        @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

        <label for="username">Username</label>
        <input 
            type="text" 
            id="username" 
            name="username" 
            placeholder="masukkan username"
            required
        >
    </div>

    <div class="form-group">
        <label for="password">Kata Sandi</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="masukkan kata sandi"
            required
        >
    </div>

    <p class="warning">Jangan bagikan password kepada siapa pun.</p>

    <button type="submit" class="btn-login">Login</button>
</form>

        </div>

        <div class="illustration">
            <img src="images/guru.png" alt="Guru">
        </div>

        <div class="background-shape"></div>
    </div>
</body>
</html>