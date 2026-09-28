<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                background-color: #fafafa;

            }

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

            .content {
                display: flex;
                flex-direction: column;
                row-gap: 8px;
            }

            .content h1 {
                font-size: 40px;
            }

            .content .link:hover {
                opacity: 0.8;
            }

            .content .login {
                /* border: 0px; */
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 8px;
                -webkit-font-smoothing: antialiased;
                padding: 0px 18px;
                font-size: 15px;
                font-weight: bold;
                cursor: pointer;
                margin-top: 10px;
                vertical-align: middle;
                text-align: center;
                background-color: rgb(230, 0, 35);
                color: rgb(255, 255, 255);
                width: 100%;
            }

            .content .register {
                display: flex;
                color: white;
                justify-content: center;
                align-items: center;
                border-radius: 8px;
                font-weight: bold;
                -webkit-font-smoothing: antialiased;
                padding: 0px 18px;
                cursor: pointer;
                text-align: left;
                background-color: rgb(24, 119, 242);
                width: 100%;
            }

            .content .link {
                text-decoration: none;
                height: 80px;
                font-size: 36px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <h1>Welcome to Realtime Online Courses</h1>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="login link">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="login link">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="register link">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </body>
</html>
