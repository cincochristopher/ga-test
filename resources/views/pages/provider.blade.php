<!DOCTYPE html>
<html>
    <head>
        <title>Provider Page</title>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1 class="title">{{ $title }}</h1>
                
                <ul>
                @forEach($programs as $program)
                    <li>
                        <h3>{{ $program['name'] }}</h3>
                        <div>Program Type: {{ $program['directory']['name'] }}</div>
                        <p>{{ $program['description'] }}</p>
                    </li>
                @endForEach
                </ul>
            </div>
        </div>
    </body>
</html>
