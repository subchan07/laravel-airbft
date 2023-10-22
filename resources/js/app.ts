// TODO make up and down navigation of the image !! DONE !!
// TODO make img click scroll to action bts !! DONE !!
// TODO make the open and close instruction functional !! DONE !!
// TODO make the mobile open and close action popup
// TODO make the remove image
// TODO make the change image functionality
// TODO button action for mobile functionality

// ? functions

const switchElement = (element1: HTMLElement, element2: HTMLElement) => {
    const parent = element1.parentElement;
    const parent2 = element2.parentElement;
    if (parent && parent2 && parent === parent2) {
        const nextSibling = element2.nextElementSibling;

        parent.insertBefore(element2, element1);
        if (nextSibling) {
            parent.insertBefore(element1, nextSibling);
        } else {
            parent.appendChild(element1);
        }
    }
};

const outsideModalClose = (content: HTMLElement) => {
    const closeModal = () => {
        content.closest("section")?.classList.add("hidden");
    };

    const listen = (e: MouseEvent) => {
        const target = e.target as HTMLElement;
        if (!content.contains(target)) {
            closeModal();
            document.removeEventListener("keydown", escape);
            document.removeEventListener("click", listen);
        }
    };
    const escape = (e: KeyboardEvent) => {
        if (e.key == "Escape") {
            closeModal();
            document.removeEventListener("keydown", escape);
            document.removeEventListener("click", listen);
        }
    };

    document.addEventListener("click", listen);
    document.addEventListener("keydown", escape);

    const closeBtn = content.querySelector(".cls") as HTMLElement;
    closeBtn.onclick = () => {
        closeModal();
        document.removeEventListener("click", listen);
        document.removeEventListener("keydown", escape);
    };
};

const upNavigation = (upNavBtn: Element) => {
    const imgContainer = upNavBtn.closest(".img-container");
    const prevSibling = imgContainer?.previousElementSibling;
    if (imgContainer && prevSibling) {
        switchElement(prevSibling as HTMLElement, imgContainer as HTMLElement);
    }
};

const downNavigation = (downNavBtn: Element) => {
    const imgContainer = downNavBtn.closest(".img-container");
    const nextSibling = imgContainer?.nextElementSibling;
    if (imgContainer && nextSibling) {
        switchElement(imgContainer as HTMLElement, nextSibling as HTMLElement);
    }
};

const imageIntoView = (image: Element) => {
    image.addEventListener("click", (e) => {
        e.preventDefault();
        const container = image.closest(".img-container")!;
        container.scrollIntoView({ behavior: "smooth" });
    });
};

const imageEdit = (edit: Element) => {
    const input = document.createElement("input");
    input.type = "file";
    input.accept = "image/*";
    input.click();
    input.addEventListener("change", (e) => {
        const inputElement = e.currentTarget as HTMLInputElement;
        const files = inputElement.files;
        if (files) {
            const file = files[0];
            const imgElement = edit.parentElement!
                .previousElementSibling as HTMLImageElement;
            const fileUrl = URL.createObjectURL(file);
            imgElement.src = fileUrl;
        }
    });
};

const imageDelete = (deleteBtn: Element) => {
    const container = deleteBtn.closest(".img-container");
    if (container) {
        container.remove();
    }
};

//? queries
const upNavigationBtns = document.querySelectorAll(".img-container .up-btn");
const downNavigationBtns = document.querySelectorAll(
    ".img-container .down-btn"
);
const images = document.querySelectorAll(".promotion-contents img");
const instructionToggler = document.querySelectorAll(
    '[data-toggle-component="instruction"]'
);
const closeInstruction = document.querySelector(".instruction-close");
const editImageBtns = document.querySelectorAll(".img-container .edit-btn");
const deleteImageBtns = document.querySelectorAll(".img-container .delete-btn");
const addImageBtn = document.getElementById("add-another-image");

//? event listeners
upNavigationBtns.forEach((upNavBtn) => {
    upNavBtn.addEventListener("click", () => {
        upNavigation(upNavBtn);
    });
});

downNavigationBtns.forEach((downNavBtn) => {
    downNavBtn.addEventListener("click", () => {
        downNavigation(downNavBtn);
    });
});
images.forEach((image) => {
    imageIntoView(image);
});
instructionToggler.forEach((toggler) => {
    toggler.addEventListener("click", (e) => {
        e.stopPropagation();
        const target = toggler.getAttribute("data-target");
        if (!target) {
            throw new Error(
                'Instruction Toggler need  "data-target" attribute'
            );
            return;
        }
        const elementTarget = document.querySelector(target);
        if (elementTarget) {
            elementTarget.classList.remove("hidden");
            const targetContent = elementTarget.querySelector(".content")!;
            outsideModalClose(targetContent as HTMLElement);
        }
    });
});
editImageBtns.forEach((edit) => {
    edit.addEventListener("click", (e) => {
        imageEdit(edit);
    });
});
deleteImageBtns.forEach((deleteBtn) => {
    deleteBtn.addEventListener("click", () => {
        imageDelete(deleteBtn);
    });
});
addImageBtn?.addEventListener("click", () => {
    const input = document.createElement("input");
    input.type = "file";
    input.accept = "image/*";
    input.click();
    input.addEventListener("change", (e) => {
        const files = input.files;
        if (files) {
            const file = files[0];
            const fileUrl = URL.createObjectURL(file);
            const imgContainer = document.querySelector(".img-container");
            if (imgContainer) {
                const cloned = imgContainer.cloneNode(true) as Element;
                const img = cloned.querySelector("img")!;
                img.classList.remove("aspect-16/1");
                img.src = fileUrl;

                const upNavBtn = cloned.querySelector(".up-btn")!;
                const downNavBtn = cloned.querySelector(".down-btn")!;
                const editBtn = cloned.querySelector(".edit-btn")!;
                const deleteBtn = cloned.querySelector(".delete-btn")!;
                upNavBtn.addEventListener("click", () => {
                    upNavigation(upNavBtn);
                });
                downNavBtn.addEventListener("click", () => {
                    downNavigation(downNavBtn);
                });
                editBtn.addEventListener("click", () => {
                    imageEdit(editBtn);
                });
                deleteBtn.addEventListener("click", () => {
                    imageDelete(deleteBtn);
                });

                const promotionContents = document.querySelector(
                    ".promotion-contents"
                )!;
                promotionContents.append(cloned);
            }
        }
    });
});
