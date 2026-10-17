{{-- BACKEND STUB: replace. Data: $topics (value => label). Honeypot field "website" must stay hidden and empty. --}}
@extends('_stubs.layout')
@section('content')
<h1>Contact</h1>
@if (session('inquiry_sent'))<p role="status">Sent.</p>@endif
<form method="post" action="{{ route('contact.store') }}">
@csrf
<input name="name" value="{{ old('name') }}">
<input name="email" type="email" value="{{ old('email') }}">
<input name="company" value="{{ old('company') }}">
<select name="topic">@foreach ($topics as $value => $label)<option value="{{ $value }}" @selected(old('topic') === $value)>{{ $label }}</option>@endforeach</select>
<textarea name="message">{{ old('message') }}</textarea>
<input name="website" tabindex="-1" autocomplete="off" hidden>
<button>Send</button>
</form>
@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
@endsection
