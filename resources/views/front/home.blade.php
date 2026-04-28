@extends('layouts.front')

@section('title', 'Cmlink | Connecte talents et entreprises')

@section('content')
    @include('front.partials.header')

    <main>
        @include('front.partials.hero')
        @include('front.partials.why-cmlink')
        @include('front.partials.audience')
        @include('front.partials.how-it-works')
        @include('front.partials.recent-offers')
        @include('front.partials.cta')
    </main>

    @include('front.partials.footer')
@endsection
