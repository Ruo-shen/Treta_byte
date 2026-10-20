@extends('layouts.app')
@section('content')
<div class="hn">
@include('components.home-next.hero')
@include('components.home-next.problems')
@include('components.home-next.services')
@include('components.home-next.process')
@include('components.home-next.why')
@include('components.home-next.work')
@include('components.home-next.about')
<x-inner.faq group="home" id="faq" tone="soft" kicker="" />
@include('components.cta')
</div>
@endsection
