// start: sidebar
const menuToggle = document.getElementById("menu-open-toggle");
const dropdownMenu = document.getElementById("dropdown-menu");
const dropdown = document.getElementById("dropdown");
const sidebarbuttons = document.querySelectorAll(".sidebar-button");
console.log(sidebarbuttons);

sidebarbuttons.forEach((element) => {
  element.addEventListener("click", (e) => {
    console.log("hola");
    const parent = element.closest(".group");
    if (parent.classList.contains("active")) {
      parent.classList.remove("active");
    } else {
      document.querySelectorAll(".sidebar-button").forEach((e) => {
        e.closest(".group").classList.remove("active");
      });
      parent.classList.add("active");
    }
  });
});

menuToggle.addEventListener("click", () => {
  menuToggle.classList.toggle("menu-open");
  dropdown.classList.toggle("menu-open");
  dropdownMenu.classList.toggle("hidden");
});
// end: sidebar
