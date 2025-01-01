const body = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar"),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");
      photo = document.getElementById("dashboardimg");


// Load the saved dark mode state from localStorage
const currentMode = localStorage.getItem("darkMode");
if (currentMode === "enabled") {
body.classList.add("dark");
modeText.innerText = "Light Mode";
}


modeSwitch.addEventListener("click", () => {
body.classList.toggle("dark");

if (body.classList.contains("dark")) {
  modeText.innerText = "Light Mode";
  localStorage.setItem("darkMode", "enabled");
  photo.src ="dashboard-welcome-night.jpg";
} else {
  modeText.innerText = "Dark Mode";
  localStorage.setItem("darkMode", "disabled");
  photo.src ="dashboard-welcome.jpg"
}
});
function initializeDashboard(currentMode) {
if (currentMode === 'dark') {
    photo.src = "dashboard-welcome-night.jpg";
} else {
    photo.src = "dashboard-welcome.jpg";
}
}

// Keep the sidebar open when navigating between pages
document.addEventListener("DOMContentLoaded", () => {
    const sidebarState = localStorage.getItem("sidebarState");

    if (sidebarState === "open") {
        sidebar.classList.remove("close");
    } else {
        sidebar.classList.add("close");
    }
});

// Save the sidebar state in localStorage when toggled
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    const sidebarState = sidebar.classList.contains("close") ? "closed" : "open";
    localStorage.setItem("sidebarState", sidebarState);
});

