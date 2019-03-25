<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Tikkie Jij Bent Hem') }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/front.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <style>
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">{{__('auth.login')}}</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">{{__('auth.register')}}</a>
                        @endif
                    @endauth
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonLocal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('header.language')}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/lang/nl"><i><span class="mr-1" role="img" id="nl"></span></i>{{__('header.dutch')}}</a>
                                <a class="dropdown-item" href= "/lang/en"><i><span class="mr-1" role="img" id="en"></span></i>{{__('header.english')}}</a>
                            </div>
                </div>
            @endif
            <div class="content">
                <div class="title m-b-md">
                    Tikkie Jij Bent Hem
                </div>

                <div class="links">
                    <a href="{{ route('register') }}"><button class="btn btn-success register">{{__('home.account')}}</button></a>
                </div>
            </div>
        </div>
    </body>
</html>
