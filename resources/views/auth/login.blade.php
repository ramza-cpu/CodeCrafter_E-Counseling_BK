<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Autentikasi Pengguna</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="background">
  <img src="{{ asset('images/login.png') }}" class="bg-image">
  <div class="overlay"></div>
</div>

<div class="birds">
  <img src="{{ asset('images/kupu.gif') }}" class="bird bird1">
  <img src="{{ asset('images/kupu.gif') }}" class="bird bird2">
  <img src="{{ asset('images/kupu.gif') }}" class="bird bird3">
</div>

<div class="container">

  <!-- LEFT SIDE (GURU) -->
  <div class="left-side">
    <img src="{{ asset('images/guru.png') }}" class="guru-img">
  </div>

  <!-- RIGHT SIDE (LOGIN) -->
  <div class="right-side">
    <div class="login-box">
      <h2>Masuk Akun Anda</h2>
      <p class="subtitle">Setiap cerita layak didengar. Smart E-Counsel ada untukmu, dengan hati. 🤍</p>

<form method="POST" action="{{ route('login.process') }}">
  @csrf

  @if(session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
  @endif

  <div class="input-group">
    <input type="text" name="username" required>
    <label>Nama Pengguna</label>
  </div>

  <div class="input-group">
    <input type="password" name="password" required>
    <label>Kata Sandi</label>
  </div>

  <button type="submit" class="btn-login">Masuk</button>
</form>
    </div>
  </div>

</div>

<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>