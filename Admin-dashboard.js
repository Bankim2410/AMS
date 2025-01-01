const cross = document.getElementById("cross"),
    content1 = document.getElementById("content1"),
    pre = document.getElementById("pre"),
    photo = document.getElementById("dashboardimg");

cross.addEventListener("click", () => {
    cross.style.display = "none";
    content1.style.display = "none";
    pre.style.display = "none";
});
