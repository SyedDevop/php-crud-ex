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
    todosList.children[0].innerHTML += `
          <li class="todo-item">
            <p onclick="toggle(this)" data-id="${data.id}" >${data.todo}</p>
            <div class="todo-action" data-id="${data.id}">
            <button class="edit-todo">
            <img src="edit.svg" alt="edit" />
            </button>
            <button class="delete-todo">
            <img src="delete.svg" alt="delete" />
            </button>
            </div>
          </li>`;
    todoForm.reset();
  } else {
    alert("Something went wrong posting todo");
  }
});

async function toggle(liElement) {
  if (liElement.contentEditable === "true") {
    return;
  }
  liElement.classList.toggle("completed");

  // isCompleted = liElement.classList.contains("completed");
  // const { id } = liElement.dataset;
  // const res = await fetch("update-state.php", {
  //   method: "POST",
  //   body: JSON.stringify({ id, state: isCompleted }),
  //   headers: {
  //     "Content-Type": "application/json",
  //   },
  // });
  // console.log(res);
}

async function deleteTodo(id) {
  fetch("delete.php", {
    method: "DELETE",
    body: JSON.stringify({ id }),
    headers: {
      "Content-Type": "application/json",
    },
  });

  todosList.childNodes[1].childNodes.forEach((e) => {
    if (e.hasChildNodes() && e.dataset.id === `${id}`) {
      todosList.childNodes[1].removeChild(e);
    }
  });
}

function editTodo(btnElement) {
  const pElement = btnElement.parentNode.parentNode.firstElementChild;
  pElement.contentEditable =
    pElement.contentEditable === "true" ? "false" : "true";
  pElement.focus();
}

const editableElements = document.querySelectorAll("[contenteditable]");
editableElements.forEach(function (element) {
  const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      if (mutation.type === "characterData") {
        console.log(mutation);
      }
    });
  });
  observer.observe(element, {
    attributes: true,
    characterData: true,
    subtree: true,
  });
});
