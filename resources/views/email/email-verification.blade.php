<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
</head>
<body>
    <div class="container">
        <div class="card card-body" style="margin-left: 40px;">
            <div>
                <a href="{{url('/')}}">Task Manager</a>
            </div>
            <h3>E-mail Verification</h3>
            <p>Hello, <br><br>
                we have sent to you email to check if this email : <a href="#">{{$user->email}}</a> you provided is valid
            </p>
            <a style="font-weight: bold;color:blue" target="_blank" href="http://127.0.0.1:8000/check_email/{{$user->remember_token}}">Check my email</a>
            <p>Yours sincerely</p>
        </div>
    </div>
</body>
</html>