@extends(backpack_view('blank'))

@section('content')
    @inertia
@endsection

@push('after_scripts')
@vite('resources/js/app.js')
@endpush