/** ROC 프로젝트 관련 Javascript For Global */

window.ROCModal = {
    show: function (
        text,
        onCancel,
        onOk,
        cancelText = "취소",
        okText = "확인"
    ) {
        this.dispose();

        const modalContainer = document.querySelector(".roc-modal-container");
        const modalContent = modalContainer.querySelector(".roc-modal-content");
        const cancelBtn = modalContainer.querySelector(".roc-modal-cancel-btn");
        const okBtn = modalContainer.querySelector(".roc-modal-ok-btn");

        modalContent.innerHTML = text;

        if (cancelText) cancelBtn.innerText = cancelText;
        const handleCancelClick = () => {
            modalContainer.style.display = "none";
            if (onCancel) onCancel();
        };
        this.onCancel = handleCancelClick;
        cancelBtn.addEventListener("click", handleCancelClick);

        if (okText) okBtn.innerText = okText;
        const handleOkClick = () => {
            modalContainer.style.display = "none";
            if (onOk) onOk();
        };
        this.onOk = handleOkClick;
        okBtn.addEventListener("click", handleOkClick);

        modalContainer.style.display = "flex";
    },
    dispose: function () {
        // 마우스 이벤트가 연결되어있으면 해제시킵니다.
        if (this.onCancel) {
            document
                .querySelector(".roc-modal-cancel-btn")
                .removeEventListener("click", this.onCancel);

            this.onCancel = null;
        }

        if (this.onOk) {
            document
                .querySelector(".roc-modal-ok-btn")
                .removeEventListener("click", this.onOk);
            this.onOk = null;
        }
    },
};

window.ROCAlert = {
    show: function (text) {
        document.querySelector(".roc-alert-content").innerHTML = text;
        document.querySelector(".roc-alert-container").style.display = "flex";
    },
};

const alertOkBtn = document.querySelector(
    ".roc-alert-container .roc-alert-ok-btn"
);

alertOkBtn.addEventListener(
    "click",
    () =>
        (document.querySelector(".roc-alert-container").style.display = "none")
);






