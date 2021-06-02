@extends('test.layouts.master')
@section('html_title', 'Şirketler')
@section('html_body')
    <ul>
        @foreach ($companies as $company)
            <li>{{$company->title}} ({{$company->company_title}})</li>
            <ul>
                @foreach($company->departments as $department)
                    <li>{{$department->title}}</li>
                @endforeach
            </ul>
        @endforeach
    </ul>
@endsection
