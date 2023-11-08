import axios from "axios";
import toastr from "toastr";
import "toastr/build/toastr.min.css";

const showToast = (message: string, type: "success" | "error" = "success") => {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        preventDuplicates: true,
        positionClass: "toast-top-right",
        showMethod: "slideDown",
        timeOut: 3000,
    };

    toastr[type](message);
};

const contactForm = document.getElementById("contact-form");
const inputPhone = document.getElementById("phone_number");

inputPhone?.addEventListener("input", (e) => {
    const input = e.currentTarget as HTMLInputElement;
    const inputValue = input.value;
    const numericValue = inputValue.replace(/[^0-9]/g, "");
    input.value = numericValue;
});

inputPhone?.addEventListener("paste", (e) => {
    const input = e.currentTarget as HTMLInputElement;
    const inputValue = input.value;
    const numericValue = inputValue.replace(/[^0-9]/g, "");
    input.value = numericValue;
});

contactForm?.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(e.currentTarget as HTMLFormElement);
    axios
        .post("/api/contacts", formData)
        .then((response) => {
            showToast("Anda akan segera kami hubungi");
        })
        .catch((error) => {
            console.error(error);
        });
});
