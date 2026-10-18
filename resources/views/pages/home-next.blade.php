@extends('layouts.app')
@section('content')
@include('components.home-next.hero')
@include('components.home-next.problems')
@include('components.home-next.services')
@include('components.home-next.why')
@include('components.home-next.process')
@include('components.home-next.about')
<x-inner.cta />
@endsection
