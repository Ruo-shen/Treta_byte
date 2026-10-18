@extends('layouts.app')
@section('footer-variant', 'next')
@section('content')
@include('components.home-next.hero')
@include('components.home-next.problems')
@include('components.home-next.services')
@include('components.home-next.why')
@include('components.home-next.process')
<x-inner.engagement id="engagement" class="hn-seam" />
@include('components.home-next.about')
<x-inner.trust id="trust" />
<x-inner.faq group="home" id="faq" tone="light" />
@include('components.home-next.closing')
@endsection
