const Register = {};

Register.init = function () {
    $(document).on("click", "#submit", () => {
        ROCModal.show(
            "이용약관 및 정보수집에 미동의 시<br/>  서비스 이용이 어렵습니다."
        );
    });
};

module.exports = Register;
