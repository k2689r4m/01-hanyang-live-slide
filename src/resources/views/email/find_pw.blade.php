<!DOCTYPE html>
<html>
<head>
    <title>임시비밀번호 발급 안내</title>
</head>
<body>
<h1>아래의 임시번호로 로그인해주세요.</h1>
<p>{{ $email }} 임시비밀번호는 {{ $password }}입니다.</p>
<a href="{{ route('user.loginView') }}">로그인 하러가기</a>
</body>
</html>
