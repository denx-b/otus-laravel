@extends('layout.main')

@section('content')

    <h1>User page</h1>

    <div class="d-inline-flex align-items-center p-2 ps-3 pe-3 rounded-pill bg-white shadow-sm">
        <img
            src="{{ $ava }}"
            alt="Avatar"
            class="rounded-circle border me-2"
            style="width: 48px; height: 48px; object-fit: cover;"
        >
        <div class="fw-semibold text-dark">
            {{ $name  }}
        </div>
    </div>

@endsection
