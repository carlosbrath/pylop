<!-- resources/views/emails/general.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['subject'] ?? 'Default Subject' }}</title>
</head>
<body>
    <h1>{{ $data['title'] ?? 'Hello!' }}</h1>
    <p>{{ $data['message'] ?? 'This is a general email.' }}</p>
</body>
</html>