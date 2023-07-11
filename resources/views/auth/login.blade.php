@extends('layouts.app')
@section('title', 'Login')
@section('titleHeader', 'Login')
@section('content')

<section>
    <div>
        <div>
            <div><i class="bi bi-globe2"></i></div>
        </div>
        <div>
            <div>
                <form action="{{route('login.authentication')}}" method="post">
                    @csrf

                    <!-- Email address input-->
                    <div>
                        <input id="email" type="email" name="email" placeholder="name@example.com" value="{{old('email')}}" />
                        <label for="email">Email address</label>
                        @if ($errors->has('email'))
                            <div>
                                {{$errors->first('email')}}
                            </div>
                        @endif
                    </div>

                    <!-- Password input-->
                    <div>
                        <input id="password" type="password" name="password" placeholder="Enter your password" />
                        <label for="password">Password</label>
                        @if ($errors->has('password'))
                            <div>
                                {{$errors->first('password')}}
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button-->
                    <button id="Login" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
