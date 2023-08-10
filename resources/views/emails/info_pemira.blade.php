<!DOCTYPE html>

<html>

<head>

    <title>INFO PEMIRA KAHIMA 2023</title>

</head>

<body>

    <h1>{{ $mailData['title'] }}</h1>

    <h2>Halo, {{ $mailData['nama'] }}</h2>

    <p>{{ $mailData['body'] }}</p>

    <p>Email Login: {{ $mailData['login_email'] }}</p>
    <p>Password Login: {{ $mailData['default_password'] }}</p>

    <p style="color: 'red'">Note: Pastikan untuk mengganti password anda</p>

</body>

</html>
