document.addEventListener("DOMContentLoaded", function () {
    const sidebarItems = document.querySelectorAll(".sidebar-list-item");

    const currentPath = window.location.pathname; // Get the current path of the page

    sidebarItems.forEach(function (item) {
        // Check if the href attribute of the sidebar item matches the current path
        if (item.getAttribute("href") === currentPath) {
            item.classList.add("active"); // Add the "active" class to the matched item
        }

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
