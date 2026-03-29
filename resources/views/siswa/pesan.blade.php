@extends('layouts.app')

@section('title', 'Pesan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pesan.css') }}">
@endpush

@section('content')

<!-- MOBILE TOPBAR (TETAP) -->
<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>

<!-- MAIN CONTENT -->
<section class="main-content">

    <!-- ========================= -->
    <!-- CHAT LIST (KIRI) -->
    <!-- ========================= -->
    <section class="chat-list">

        <!-- Header -->
        <div class="chat-list-header">
            <h3>Pesan</h3>
        </div>

        <!-- Search -->
        <div class="search">
            <input type="text" id="searchChat" placeholder="Cari chat..." />
        </div>

        <!-- LIST CHAT -->
        <div class="chat-items" id="chatItems">
            <div class="loading-state">
                <p>Memuat chat...</p>
            </div>
        </div>

    </section>


    <!-- ========================= -->
    <!-- CHAT ROOM (KANAN) -->
    <!-- ========================= -->
    <section class="chat-room">

        <!-- HEADER -->
        <div class="chat-header">
            <button class="back-btn" onclick="goBack()">
                <i class="fas fa-arrow-left"></i>
            </button>

            <div class="chat-header-info">
                <h4 id="chatName">Pilih chat untuk memulai</h4>
                <p class="status">Online</p>
            </div>
        </div>

        <!-- BODY -->
        <div class="chat-body" id="chatBody">
            <div class="empty-state">
                <i class="fas fa-comments"></i>
                <p>Pilih percakapan untuk memulai chat</p>
            </div>
        </div>

        <!-- INPUT -->
        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Tulis pesan..." />
            <button type="button" id="sendBtn">
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
        </div>

    </section>

</section>

@endsection

@push('scripts')
@vite(['resources/js/bootstrap.js']) 
<script src="{{ asset('js/siswa/pesan.js') }}"></script>
@endpush