@extends('layouts.app')
@section('title', 'Login')
@section('titleHeader', 'Login')
@section('content')
<section class="bg-light py-5">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-pencil-square"></i></div>
                    <h2 class="fw-bolder">register</h2>
                    <p class="lead mb-0">enter your infos</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                    <form action="/register" method="post">
                                @csrf

                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="nom" type="text" name="nom" placeholder="Enter your last name" value="{{old('nom')}}" />
                                <label for="name">Last name</label>
                                @if ($errors->has('name'))
                                        <div class="text-danger mt-2">
                                            {{$errors->first('name')}}
                                        </div>
                                @endif
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="prenom" type="text" name="prenom" placeholder="Enter your first name" value="{{old('prenom')}}" />
                                <label for="prenom">First name</label>
                                @if ($errors->has('name'))
                                        <div class="text-danger mt-2">
                                            {{$errors->first('name')}}
                                        </div>
                                @endif
                            </div>



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
                                <input class="form-control" id="password" name="password" type="password" placeholder="Enter your password"  />
                                <label for="password">Password</label>
                                @if ($errors->has('password'))
                                        <div class="text-danger mt-2">
                                            {{$errors->first('password')}}
                                        </div>
                                @endif
                            </div>
                            <!-- date of birth input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="date_of_birth" type="date" name="date_naissance" placeholder="Enter your date of birth" />
                                <label for="date_of_birth">Date of birth</label>
                                @if ($errors->has('date_of_birth'))
                                        <div class="text-danger mt-2">
                                            {{$errors->first('date_of_birth')}}
                                        </div>
                                @endif
    
                            <!-- Submit Button-->
                            <button class="btn btn-primary btn-lg" id="Login" type="submit">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @endsection