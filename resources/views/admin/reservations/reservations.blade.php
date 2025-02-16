@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Rezerwacje
            </h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('admin.reservations-list')
        </div>
    </div>
@endsection
