@extends('dummy-vpos::layout.main-layout')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
            <div class="max-w-md mx-auto">
                <div class="flex flex-col">
                    <h1>
                        <i class="mdi mdi-close-network-outline mr-4"></i>
                        Invalid success, error callback or price
                    </h1>

                    <pre class="mt-6">
                        {{ print_r(request()->all(), true) }}
                    </pre>

                    <a href="{{ url('/') }}">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
