"use strict";

const profile = document.querySelector(".position_container");
const collections = document.querySelector(".user_collections");
const collectionListElement = document.querySelectorAll(".main_catalog_section");
const collectionElements = [];

for (const list of collectionListElement) {
    let newList = list.querySelectorAll(".main_catalog_link");
    collectionElements.push(newList);
}

for (const list of collectionElements) {
    list.forEach((el) => (el.draggable = true));
}

collectionListElement.forEach((el) => {
    el.addEventListener(`dragstart`, (evt) => {
        evt.target.classList.add(`selected`);
    });

    el.addEventListener(`dragend`, (evt) => {
        evt.target.classList.remove(`selected`);
        dragend(evt);
    });
});

const getNextElement = (cursorPosition, currentElement) => {
    const currentElementCoord = currentElement.getBoundingClientRect();
    const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
    const nextElement = cursorPosition < currentElementCenter
        ? currentElement
        : currentElement.nextElementSibling;

    return nextElement;
};

collectionListElement.forEach((el) => {
    el.addEventListener(`dragover`, (evt) => {
        evt.preventDefault();
        const activeElement = document.querySelector(`.selected`);
        const currentElementChildren = evt.target;
        let currentElement = currentElementChildren.parentElement;
        let parentBlock = currentElement.parentElement;

        if (currentElement.classList.contains("main_catalog")) {
            let newParentBlock = currentElement.querySelector(".main_catalog_section");
            newParentBlock.prepend(activeElement);
        } else if (currentElement.classList.contains(`main_catalog_link`)) {
            const isMoveable = activeElement !== currentElement &&
                currentElement.classList.contains(`main_catalog_link`);

            if (!isMoveable) {
                return;
            }

            const nextElement = getNextElement(evt.clientY, currentElement);
            parentBlock.insertBefore(activeElement, nextElement);
        }
    });

    el.addEventListener("drop", handleDrop);
});

function addClass() {
    profile.classList.add("fixed-position");
    collections.classList.add("collections_margin");
    setNewWidth();
}

function removeClass() {
    profile.classList.remove("fixed-position");
    collections.classList.remove("collections_margin");
    profile.removeAttribute("style");
}

function findWidthCollectionsBlock() {
    return collections.clientWidth;
}

function setNewWidth() {
    let newWidth = findWidthCollectionsBlock() + 2;
    let strWidth = String(newWidth);
    profile.style.width = strWidth + "px";
}

window.addEventListener("scroll", (e) => {
    // let positionY = window.scrollY;
    //
    // if (positionY > 115) {
    //     let colWidth = String(collections.clientWidth + 2) + "px";
    //
    //     if (profile.style.width != colWidth) {
    //         setNewWidth();
    //     }
    //     if (profile.classList.contains("fixed-position")) {
    //         return;
    //     } else {
    //         addClass();
    //     }
    // } else if (positionY < 115) {
    //     if (profile.classList.contains("fixed-position")) {
    //         removeClass();
    //     } else {
    //         return;
    //     }
    // }
});

function handleDrop(e) {
    e.preventDefault();
    return false;
}

function dragend(e) {
    let card = e.target;

    if (card !== undefined) {
        let new_list_id = e.currentTarget.id.replace(/list_id_/, '');
        let old_list_id = card.getAttribute('data-list_id');

        if (new_list_id !== old_list_id) {
            let film_id = card.id.replace(/film_id_/, '');
            card.setAttribute('data-list_id', new_list_id);

            $.ajax({
                type: "POST",
                url: "/move_film_from_list_to_list",
                data: {
                    new_list_id: new_list_id,
                    film_id: film_id,
                    old_list_id: old_list_id
                },
                success: function (response) {
                    return response;
                }
            });
        }
    }
}
