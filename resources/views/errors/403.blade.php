@extends('errors::minimal')

@section('title', __('Acesso proibido.'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Acesso proibido.'))
