import axios from 'axios';
import 'toastr/build/toastr.min.css';
import toastr from 'toastr';

//? Globar Variables
let changed = false;
const changedThings : any[] = [];
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
const saveBtn = document.getElementById('save-change') as HTMLButtonElement;

// ? functions

const showToast = (message:string, type: 'success' | 'error' = 'success') => {
    toastr.options = {
        closeButton:true,
        progressBar:true,
        preventDuplicates:true,
        positionClass: 'toast-top-right',
        showMethod: 'slideDown',
        timeOut: 3000
    }

    toastr[type](message);
}

const disableSave = (text:string) => {
    saveBtn.disabled = true;
    saveBtn.textContent = text;
}

const enableSave = () => {
    if(changed) {
        const saveButton = document.getElementById('save-change') as HTMLButtonElement;
        saveButton.disabled = false;
        saveButton.textContent = 'Save';
    }
}

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
    changed = true;
    enableSave();
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
    const dataOrder = upNavBtn.getAttribute('data-order');
    const dataId = upNavBtn.getAttribute('data-id');
    if (imgContainer && prevSibling) {
        switchElement(prevSibling as HTMLElement, imgContainer as HTMLElement);
        changedThings.push({type: 'Move Up', order: dataOrder, id:dataId});
    }
};

const downNavigation = (downNavBtn: Element) => {
    const imgContainer = downNavBtn.closest(".img-container");
    const nextSibling = imgContainer?.nextElementSibling;
    const dataOrder = downNavBtn.getAttribute('data-order');
    const dataId = downNavBtn.getAttribute('data-id');
    if (imgContainer && nextSibling) {
        switchElement(imgContainer as HTMLElement, nextSibling as HTMLElement);
        changedThings.push({type: 'Move Down', order: dataOrder, id:dataId});
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
            changed = true;
            const dataOrder = edit.getAttribute('data-order');
            const dataId = edit.getAttribute('data-id');
            changedThings.push({type: 'Change Image', file, order: dataOrder, id:dataId});
            enableSave();
        }
    });
};

const imageDelete = (deleteBtn: Element) => {
    const dataOrder = deleteBtn.getAttribute('data-order');
    const dataId = deleteBtn.getAttribute('data-id');
    const container = deleteBtn.closest(".img-container");
    if (container) {
        container.remove();
        changed = true;
        changedThings.push({type: 'Delete Image', order: dataOrder, id:dataId});
        enableSave();
    }
};

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
            axios.post('/api/promotions').then(response => {
                const promotion = response.data;
                const file = files[0];
                const fileUrl = URL.createObjectURL(file);
                const existImgContainer = document.querySelector(".img-container");

                if (existImgContainer) {
                    const cloned = existImgContainer.cloneNode(true) as Element;
                    const img = cloned.querySelector("img")!;
                    img.classList.remove("aspect-16/1");
                    img.src = fileUrl;

                    const upNavBtn = cloned.querySelector(".up-btn")!;
                    const downNavBtn = cloned.querySelector(".down-btn")!;
                    const editBtn = cloned.querySelector(".edit-btn")!;
                    const deleteBtn = cloned.querySelector(".delete-btn")!;
                    upNavBtn.setAttribute('data-id', promotion.id);
                    upNavBtn.setAttribute('data-order', promotion.order);
                    downNavBtn.setAttribute('data-id', promotion.id);
                    downNavBtn.setAttribute('data-order', promotion.order);
                    editBtn.setAttribute('data-id', promotion.id);
                    editBtn.setAttribute('data-order', promotion.order);
                    deleteBtn.setAttribute('data-id', promotion.id);
                    deleteBtn.setAttribute('data-order', promotion.order);
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
                    img.addEventListener('click', () => {
                        imageIntoView(img);
                    })

                    const promotionContents = document.querySelector(
                        ".promotion-contents"
                    )!;
                    promotionContents.append(cloned);
                } else {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('img-container');
                    const imgElement = document.createElement('img');
                    imgElement.addEventListener('click', () => {
                        imageIntoView(imgElement);
                    })
                    imgElement.src = fileUrl;
                    imgElement.classList.add('promotion-image','aspect-16/1');
                    const actionContainer = document.createElement('div');
                    actionContainer.classList.add('action-container');
                    const editBtn = document.createElement('button');
                    const upBtn = document.createElement('button');
                    const downBtn = document.createElement('button');
                    const deleteBtn = document.createElement('button');
                    upBtn.setAttribute('data-id', promotion.id);
                    upBtn.setAttribute('data-order', promotion.order);
                    downBtn.setAttribute('data-id', promotion.id);
                    downBtn.setAttribute('data-order', promotion.order);
                    editBtn.setAttribute('data-id', promotion.id);
                    editBtn.setAttribute('data-order', promotion.order);
                    deleteBtn.setAttribute('data-id', promotion.id);
                    deleteBtn.setAttribute('data-order', promotion.order);
                    editBtn.classList.add('edit-btn','instruction-btn');
                    upBtn.classList.add('up-btn','instruction-btn');
                    downBtn.classList.add('down-btn','instruction-btn');
                    deleteBtn.classList.add('delete-btn','instruction-btn');
                    upBtn.addEventListener("click", () => {
                        upNavigation(upBtn);
                    });
                    downBtn.addEventListener("click", () => {
                        downNavigation(downBtn);
                    });
                    editBtn.addEventListener("click", () => {
                        imageEdit(editBtn);
                    });
                    deleteBtn.addEventListener("click", () => {
                        imageDelete(deleteBtn);
                    });
                    const editIcon = document.createElement('i');
                    const upIcon = document.createElement('i');
                    const downIcon = document.createElement('i');
                    const deleteIcon = document.createElement('i');
                    editIcon.classList.add('fas','fa-edit','fa-xs');
                    upIcon.classList.add('fas','fa-arrow-alt-circle-up');
                    downIcon.classList.add('fas','fa-arrow-alt-circle-down');
                    deleteIcon.classList.add('fas','fa-window-close');
                    editIcon.style.color = '#fff';
                    upIcon.style.color = '#fff';
                    downIcon.style.color = '#fff';
                    deleteIcon.style.color = '#fff';

                    editBtn.append(editIcon);
                    upBtn.append(upIcon);
                    downBtn.append(downIcon);
                    deleteBtn.append(deleteIcon);
                    actionContainer.append(editBtn, upBtn, downBtn, deleteBtn);
                    imgContainer.append(imgElement, actionContainer);

                    const promotionContents = document.querySelector('.promotion-contents');
                    promotionContents?.append(imgContainer);
                }
                changed = true;
                enableSave();
                changedThings.push({type: 'Add Image', file, id: promotion.id});
            })

        }
    });
});
saveBtn?.addEventListener('click', () => {
    disableSave('Saving');
    const formData = new FormData();
    changedThings.forEach((item,index) => {
        formData.append(`changedThings[${index}][type]`, item.type);
        formData.append(`changedThings[${index}][id]`, item.id)            ;

        if(item.type == 'Add Image') {
            formData.append(`changedThings[${index}][file]`, item.file);
        } else if (item.type == 'Change Image') {
            formData.append(`changedThings[${index}][file]`, item.file);
            formData.append(`changedThings[${index}][order]`, item.order);
        } else {
            formData.append(`changedThings[${index}][order]`, item.order);
        }
    })
    formData.append('_method','put');
    axios.post('/api/promotions', formData , {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => {
        console.log(response);
        showToast('Berhasil Disimpan');
        disableSave('Save');
        changed = false;

    }).catch(error => {
        showToast('Gagal Disimpan', 'error');
        enableSave();
        console.log(error);
    })
})
window.addEventListener('beforeunload', (event) => {
    if(changed) {
        event.returnValue = 'You have unsaved changes. Are you sure you want to leave this page?';
    }
})
