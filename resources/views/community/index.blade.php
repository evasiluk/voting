@extends('layouts.app')

@section('content')
    <div class="container">
    @include('flash::message')
        <div class="row">
            <div class="col-md-8">
                <h3><a href="/community">Community </a><span>@if($channel) &mdash; {{$channel->title}} @endif</span></h3>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{request()->exists('popular')? '' : 'active'}}" href="{{request()->url()}}">Most Recent</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->exists('popular')? 'active' : ''}}" href="?popular">Most Popular</a>
                    </li>
                </ul>
                @include('community.list')
            </div>
            @include('community.add-link')
        </div>
    </div>
@endsection