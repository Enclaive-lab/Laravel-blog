@extends('admin.layouts.app')

@section('title', 'Новая публикация')
@section('breadcrumb', 'Новая публикация')

@section('content')
    @include('admin.posts._form')
@endsection
