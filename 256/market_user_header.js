document.addEventListener("DOMContentLoaded", function () {
    const sidebarItems = document.querySelectorAll(".sidebar-list-item");


    const activeItem = localStorage.getItem("activeSidebarItem");


    if (activeItem) {
        const activeElement = document.querySelector(`[data-id="${activeItem}"]`);
        if (activeElement) {
            activeElement.classList.add("active");
        }
    }

 
    sidebarItems.forEach(function (item) {
        item.addEventListener("click", function () {
            // Remove the "active" class from the currently active item
            const currentActive = document.querySelector(".sidebar-list-item.active");
            if (currentActive) {
                currentActive.classList.remove("active");
            }

            // Add the "active" class to the clicked item
            item.classList.add("active");

            // Save the active item id in localStorage
            localStorage.setItem("activeSidebarItem", item.getAttribute("data-id"));
        });
    });
});
