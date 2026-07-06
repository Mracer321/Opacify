@extends('layouts.app')

@section('title', $service['title'] . ' Services — OpacifyWeb')
@section('meta_description', $service['meta_description'])
@section('canonical', 'https://opacifyweb.in/services/' . $service['slug'])

@section('content')
    <x-service-detail-page :service="$service" />
    <x-cta-banner
        :title="'Ready to start ' . $service['title'] . '?'"
        :primaryHref="'/services/' . $service['slug'] . '#consultation'"
        primaryLabel="Request consultation"
    />
@endsection
