document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll("[data-toggle-password]").forEach((button) => {

        button.addEventListener("click", () => {

            const wrapper = button.parentElement;
            const input = wrapper.querySelector("input");

            if (!input) return;

            const eyeOpen = button.querySelector(".eye-open");
            const eyeClosed = button.querySelector(".eye-closed");

            if (input.type === "password") {
                input.type = "text";

                eyeOpen.classList.add("hidden");
                eyeClosed.classList.remove("hidden");
            } else {
                input.type = "password";

                eyeOpen.classList.remove("hidden");
                eyeClosed.classList.add("hidden");
            }

        });

    });

});
