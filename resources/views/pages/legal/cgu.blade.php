@extends('layouts.front')

@section('title', $page->title . ' | Cmlink')

@section('content')

    @include('front.partials.header')

    <main>

        @include('pages.legal.partials.hero')

        @include('pages.legal.partials.content')

    </main>

    @include('front.partials.footer')

@endsection
