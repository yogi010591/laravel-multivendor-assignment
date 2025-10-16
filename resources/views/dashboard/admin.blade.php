@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    {{-- Dashboard Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-600">Welcome, {{ Auth::user()->name }} 👋</p>
        </div>
    </div>


@endsection
