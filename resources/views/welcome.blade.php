<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pusher Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">
    <style>
        body {
            padding-top: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="/post">
            {{ csrf_field() }}
            <div class="form-group">
                Title
                <input type="text" name="title" class="form-control" autofocus
                    value="{{ Faker\Factory::create()->sentence }}">
            </div>
            <div class="form-group">
                Body
                <textarea name="body"  class="form-control">{{ Faker\Factory::create()->paragraph }}</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Post</button>
            </div>
        </form>

        <hr>

        @foreach($posts as $post)
        <div class="alert alert-secondary">
            <div><strong>{{ $post->title }}</strong></div>
            <div class="mx-right"><small class="text-muted">{{ $post->created_at->toDayDateTimeString() }}</small></div>
            <div class="pt-2">{{ $post->body }}</div>
        </div>
        <hr>
        @endforeach
    </div>


    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        let pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            encrypted: true
        });

        let channel = pusher.subscribe('posts');

        channel.bind('post.new', function(data) {
          console.log(data)

          new Noty({
            theme: 'sunset',
            type: 'info',
            timeout: 2000,
            text: `We just got a new post! <br><br><strong>${data.post.title}</strong>`
          }).show();

        });
    </script>
</body>
</html>
