@extends('layouts.app')
@section('title', 'Login')
@section('titleHeader', 'Login')
@section('content')
<section class="bg-light py-5">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-globe2"></i></div>
                    <h2 class="fw-bolder">Login</h2>
                    <p class="lead mb-0">entter your infos</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                    <form action="{{route('login.authentication')}}" method="post">
                                @csrf

                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" type="email" name="email" placeholder="name@example.com" value="{{old('email')}}" />
                                <label for="email">Email address</label>
                                @if ($errors->has('email'))
                                        <div class="text-danger mt-2">
                                            {{$errors->first('email')}}
                                        </div>
                                @endif
                            </div>

                            <!-- Password input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" type="password" name="password" placeholder="Enter your password" />
                                <label for="password">Password</label>
                                @if ($errors->has('password'))
                                        <div class="text-danger mt-2">
                                            {{$errors->first('password')}}
                                        </div>
                                @endif
    
                            <!-- Submit Button-->
                            <button class="btn btn-primary btn-lg" id="Login" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @endsection