@extends('test.layouts.master')
@section('html_title', 'Departmanlar')
@section('html_body')
    <ul>
        @foreach ($departments as $department)
            <li>{{$department->title}} (Şirket: {{$department->company->title}})</li>
        @endforeach
    </ul>
@endsection
