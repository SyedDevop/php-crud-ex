<?php
require_once 'db.php';
create_table();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="icon" type="image/x-icon" href="favicon.ico" />

  <!-- Google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <title>CRUD Testing</title>
</head>
<!-- Ui ref https://p912n.csb.app/ -->
<!-- Edit ref https://codepen.io/nigeljohnwade/pen/zKOJbg -->
<!-- <script> -->
<!--   (async () => { -->
<!--     const res = await fetch("delete.php", { -->
<!--       method: "DELETE", -->
<!--       headers: { -->
<!--         "Content-Type": "application/json", -->
<!--       }, -->
<!--       body: JSON.stringify({ -->
<!--         docId: "123456", -->
<!--         name: "Syed uzair ahmed", -->
<!--       }), -->
<!--     }); -->
<!--     if (res.ok) { -->
<!--       const data = await res.json(); -->
<!--       document.getElementById("status").innerText = `Status: ${data.status}`; -->
<!--       document.getElementById( -->
<!--         "message", -->
<!--       ).innerText = `Message: ${data.message}`; -->
<!--       document.getElementById("name").innerText = `Name: ${data.name}`; -->
<!--     } -->
<!--   })(); -->
<!-- </script> -->

<body>
  <main id="app">
    <header>
      <h1>Todo List</h1>
      <h5>A simple PHP Todo List App</h5>
      <hr />
    </header>
    <div id="todo-list">
      <ul>
        <?php
        require_once "db.php";
        $res = get_all_todos();
        foreach ($res as $todo) {
          $todoSate = "";
          if ($todo['status'] == 1) {
            $todoSate = "completed";
          }
          $element = <<<EOD
              <li class='todo-item' data-id="{$todo['id']}">
                <p onclick='toggle(this)' class="$todoSate" data-id="{$todo['id']}" contenteditable=false> $todo[todo] </p>
                <div class="todo-action" data-id="{$todo['id']}">
                  <button class="edit-todo" onclick="editTodo(this)">
                    <img src="edit.svg" alt="edit" />
                  </button>
                  <button class="delete-todo" onclick="deleteTodo({$todo['id']})">
                    <img src="delete.svg" alt="delete" />
                  </button>
                </div>
              </li>
              EOD;
          echo $element;
        }
        ?>

      </ul>
    </div>
    <form id="todo-form">
      <label for="todo">New todo</label>
      <input type="text" name="todo" id="todo" placeholder="Add Todo" />
      <button type="submit">Add Todo</button>
    </form>
  </main>
</body>
<script src="script.js"></script>

</html>
