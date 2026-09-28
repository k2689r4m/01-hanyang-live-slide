<!DOCTYPE html>
<html>
<head>
    <title>회원가입 인증메일입니다.</title>
</head>
<body>
<h1>아래 링크를 클릭하시면 회원가입이 완료됩니다.</h1>
<a href="{{ route('user.emailVerify', [ 'email' => $user['email'], 'email_verify_code' => $user['email_verify_code']]) }}">회원가입 인증하기</a>
</body>
</html>
