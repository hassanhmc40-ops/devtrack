<?php

// The /dashboard route is handled by ProjectController@index
// which renders projects.index directly.
// This file is a fallback redirect in case it is ever called.

use Illuminate\Support\Facades\Route;

?>
@php
    // Safety redirect — the real dashboard is served by ProjectController@index
    // returning view('projects.index'). This file should not be reached normally.
@endphp

<x-app-layout>
    @section('title', 'Dashboard')
    @section('topbar-title', 'Dashboard')
    <div style="text-align:center;padding:80px 0;">
        <p style="font-size:14px;color:#6b7280;">Redirecting to your projects…</p>
        <script>window.location.href = '{{ route("projects.index") }}';</script>
    </div>
</x-app-layout>
