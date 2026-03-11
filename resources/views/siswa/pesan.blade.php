@extends('layouts.app')

@section('title', 'Pesan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/siswa/pesan.css') }}">
@endpush

@section('content')

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>


<section class="main-content">
  <!-- MAIN CONTENT -->

    <!-- CHAT LIST -->
    <section class="chat-list">

      <!-- HEADER PESAN -->
      <div class="chat-list-header">
        <h3>Pesan</h3>
        <button class="more-btn">⋮</button>
      </div>

      <!-- SEARCH -->
      <div class="search">
        <input type="text" placeholder="Cari chat..." />
      </div>

      <!-- CHAT ITEM 1 -->
      <div class="chat-item active"
        onclick="openChat(this, 'Bu Imas',
        'assalamualaikum ibu, aku mau konseling online hehe.',
        'waalaikum salam, Bu Imas. boleh silahkan yaa 😊')">
        

        <div class="avatar">👤</div>
        <div class="chat-info">
          <h4>Bu Imas</h4>
          <p>kurang lebih seperti itu ceritanya...</p>
        </div>
        <span class="time">15:41</span>
      </div>



    </section>

    <!-- CHAT ROOM -->
    <section class="chat-room">

      <div class="chat-header">
        <!-- <button class="menu-toggle" onclick="toggleSidebar()">☰</button> -->
        <button class="back-btn" onclick="goBack()">←</button>
        <h3 id="chatName">Bu Imas</h3>
      </div>

      <div class="chat-body" id="chatBody">
        <div class="message right">
          assalamualaikum ibu, aku mau konseling online hehe.
        </div>

        <div class="message left">
          waalaikum salam, ikan terbang. boleh silahkan yaa 😊
        </div>
      </div>

      <div class="chat-input">
        <input type="text" placeholder="Tulis pesan..." />
        <button type="button">Kirim</button>
      </div>

    </section>


</section>

@endsection

@push('scripts')
<script src="{{ asset('js/siswa/pesan.js') }}"></script>
@endpush