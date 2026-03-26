@extends('errors.layout')

@section('title', 'Too Many Requests')
@section('code', '429')
@section('icon', 'bi-speedometer2')
@section('message', "You're moving a bit too fast! Please slow down and wait a few moments before trying again.")
