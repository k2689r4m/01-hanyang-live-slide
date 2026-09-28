const Login = {};

Login.init = function () {
    $(document).on("click", ".roc-login-btn", () => {
        ROCAlert.show("아이디를 입력하세요.");
    });

    $(document).on("click", ".roc-signup-btn", () => {
        ROCModal.show(
            "이메일 인증이 안된 회원입니다.<br/>메일에서 받은 인증 URL을 확인해주세요.<br/>만약 URL을 받지 못한 경우<br/>인증URL 재전송을 눌러 새 인증URL로 접속해주세요.",
            () => {
                console.log("cancel");
            },
            () => {
                console.log("ok");
            },
            "기존 메일을 확인할게요",
            "새 인증 URL 받기"
        );
    });
};

module.exports = Login;
