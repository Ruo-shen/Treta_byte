@extends('layouts.app')
@section('content')
@include('components.page-intro', ['eyebrow' => 'About TRETA Lab', 'heading' => 'Three friends. One shared responsibility.', 'intro' => 'We started TRETA Lab around a simple idea: technology should work for the people who depend on it. That means useful systems, clear conversations, and staying accountable for the work.'])
@include('components.home.about')
@include('components.home.why')
@include('components.home.process')
@include('components.cta')
@endsection
