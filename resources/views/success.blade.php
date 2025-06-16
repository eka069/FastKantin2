@extends('layout.master')

@section('title', 'Berhasil')

@section('content')
<div class="w-full h-screen overflow-hidden flex flex-col items-center justify-center bg-white px-4">
  <div class="mb-6">
    <img src="{{ asset('assets/images/success.svg') }}" alt="Success" class="w-32 h-32 object-contain">
  </div>

  <h2 class="text-2xl font-semibold text-green-600 mb-2 text-center">
    Orderan Anda Telah Diterima!
  </h2>
  <p class="text-gray-600 text-center mb-6">
    Mohon tunggu, pesanan Anda sedang diproses.
  </p>

  <a href="{{ route('home') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-xl shadow-md transition duration-200">
    Kembali ke Menu
  </a>
</div>
@endsection
