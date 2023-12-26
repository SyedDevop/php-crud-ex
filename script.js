const todosList = document.getElementById("todo-list");

const todoForm = document.getElementById("todo-form");
todoForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  let formData = new FormData(e.target);
  formData.append("id", `${new Date().getTime()}`);

  const res = await fetch("post-todo.php", {
    method: "POST",
    body: formData,
  });

  if (res.ok) {
    const data = await res.json();
    todosList.children[0].innerHTML += `<li class="todo-item" ><p onclick="toggle(this)">${data.todo}</p>
          <button class="delete-todo" data-id="${data.id}">Delete</button>
          </li>`;
    todoForm.reset();
  } else {
    alert("Something went wrong posting todo");
  }
});

function toggle(liElement) {
  liElement.classList.toggle("completed");
}
