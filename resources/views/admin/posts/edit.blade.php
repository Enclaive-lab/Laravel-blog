@extends('admin.layouts.app')

@section('title', 'Редактировать публикацию')
@section('breadcrumb', 'Редактирование')

@section('content')
    @include('admin.posts._form', ['post' => $post])
@endsection
