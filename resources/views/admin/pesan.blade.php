@extends('layouts.app')

@section('title', 'Pesan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pesan.css') }}">
@endpush

@section('content')

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>


   <!-- MAIN CONTENT -->
            <section class="main-content">
                
                <!-- CHAT LIST (SIDEBAR KIRI) -->
                <section class="chat-list">
                    
                    <!-- Header Chat List -->
                    <div class="chat-list-header">
                        <h3>Pesan</h3>
                    </div>
                    
                    <!-- Search -->
                    <div class="search">
                        <input type="text" id="searchChat" placeholder="Cari chat..." />
                    </div>
                    
                    <!-- Chat Items Container -->
                    <div class="chat-items" id="chat-list">
                        <!-- Chat items will be loaded here by JavaScript -->
                        <div class="loading-state">
                            <p>Memuat chat...</p>
                        </div>
                    </div>
                    
                </section>
                
                <!-- CHAT ROOM (KANAN) -->
                <section class="chat-room">
                    
                    <!-- Chat Header -->
                    <div class="chat-header">
                        <button class="back-btn" onclick="goBack()">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div class="chat-header-info">
                            <h4 id="chatName">Pilih chat untuk memulai</h4>
                            <p class="status">Online</p>
                        </div>
                    </div>
                    
                    <!-- Chat Body -->
                    <div class="chat-body" id="chat-box">
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <p>Pilih percakapan untuk memulai chat</p>
                        </div>
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="chat-input">
                        <input type="text" id="message-input" placeholder="Tulis pesan..." />
                        <button type="button" onclick="sendMessage()">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                    
                </section>
                
            </section>
@endsection

@push('scripts')
@vite(['resources/js/bootstrap.js']) 
<script src="{{ asset('js/admin/pesan.js') }}"></script> 
@endpush