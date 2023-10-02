const createForm = document.getElementById("create-form");
const openCreateFormBtn = document.getElementById("open-create-form");
const closeCreateFormBtn = document.getElementById("close-create-form");
const editForm = document.getElementById("edit-form");
const openEditFormBtn = document.getElementById("open-edit-form");
const closeEditFormBtn = document.getElementById("close-edit-form");

openCreateFormBtn.addEventListener("click", () => {
  createForm.classList.toggle("hidden");
});

closeCreateFormBtn.addEventListener("click", () => {
  createForm.classList.toggle("hidden");
});

openEditFormBtn.addEventListener("click", () => {
  editForm.classList.toggle("hidden");
});

closeEditFormBtn.addEventListener("click", () => {
  editForm.classList.toggle("hidden");
});
