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
    todoForm.reset();
    location.reload();
  } else {
    alert("Something went wrong posting todo");
  }
});

async function toggle(liElement) {
  if (liElement.contentEditable === "true") {
    return;
  }
  liElement.classList.toggle("completed");

  isCompleted = liElement.classList.contains("completed");
  const { id } = liElement.dataset;
  const res = await fetch("update.php", {
    method: "POST",
    body: JSON.stringify({ id, state: isCompleted }),
    headers: {
      "Content-Type": "application/json",
    },
  });
  console.log(res);
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

// Toggle edit Todo element<p>.
/**
 *@param {HTMLElement} - Edit icon button.
 */
function editTodo(btnElement) {
  btnElement.classList.toggle("editing");
  const pElement = btnElement.parentNode.parentNode.firstElementChild;
  pElement.contentEditable =
    pElement.contentEditable === "true" ? "false" : "true";
  pElement.focus();
}

// Listen for todo edit events and update database.
Array.from(document.querySelectorAll("[contenteditable]")).forEach(
  function (element) {
    element.addEventListener("beforeinput", async (event) => {
      if (event.inputType === "insertParagraph") {
        event.preventDefault();
        const pElement = event.target;
        const editButton = pElement.nextElementSibling.firstElementChild;

        const id = pElement.dataset["id"];
        pElement.focus();
        pElement.contentEditable =
          pElement.contentEditable === "true" ? "false" : "true";
        editButton.classList.toggle("editing");

        const res = await fetch("update.php", {
          method: "POST",
          body: JSON.stringify({ id, todo: pElement.innerText }),
          headers: {
            "Content-Type": "application/json",
          },
        });
        console.log(res);
      }
    });
  },
);
