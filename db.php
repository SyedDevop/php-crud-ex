<?php
if (!class_exists('MyDB')) {
  class MyDB extends SQLite3
  {
    function __construct($path)
    {
      $this->open($path);
    }
  }
}

function create_table()
{

  $db = new MyDB('./test.db');
  if (!$db) {
    echo 'Error : Failed to connect to database.';
  }
  $sql = "CREATE TABLE IF NOT EXISTS todos ( id INTEGER PRIMARY KEY, todo TEXT, status BOOLEAN);";
  $res = $db->exec($sql);
  $db->close();
  if ($res) {
    return "Table created successfully\n";
  } else {
    return $db->lastErrorMsg();
  }
}

function get_all_todos()
{
  $db = new MyDB('./test.db');
  if (!$db) {
    echo 'Error : Failed to connect to database.';
  }
  $sql = "SELECT * FROM todos;";
  $res = $db->query($sql);
  $data = [];
  if ($res) {
    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
      array_push($data, $row);
    }
  } else {
    echo $db->lastErrorMsg();
  }
  $db->close();
  return $data;
}

function add_todo($id, $todo)
{
  $db = new MyDB('./test.db');
  if (!$db) {
    return 'Error : Failed to connect to database.';
  }
  $sql = "INSERT INTO todos(id,todo, status) VALUES($id,'$todo', 0);";
  $res = $db->exec($sql);
  $db->close();
  return $res;
}

function delete_todo($id)
{
  $db = new MyDB('./test.db');
  if (!$db) {
    echo 'Error : Failed to connect to database.';
  }
  $sql = "DELETE FROM todos WHERE id = $id";
  $res = $db->exec($sql);
  if ($res == false) {
    echo 'Error : Failed to delete data.';
  } else {
    echo 'Success : Data deleted successfully.';
  }
  $db->close();
  return $res;
}

function update_todo($id, $todo)
{
  $db = new MyDB('./test.db');
  if (!$db) {
    echo 'Error : Failed to connect to database.';
  }
  $sql = "UPDATE todos SET todo = '$todo' WHERE id = $id;";
  $res = $db->exec($sql);
  if ($res == false) {
    echo 'Error : Failed to update data.';
  } else {
    echo 'Success : Data updated successfully.';
  }
  $db->close();
  return $res;
}

function update_status($id, $status)
{
  $db = new MyDB('./test.db');
  if (!$db) {
    echo 'Error : Failed to connect to database.';
  }
  $sql = "UPDATE todos SET status = '$status' WHERE id = $id;";
  $res = $db->exec($sql);
  if ($res == false) {
    echo 'Error : Failed to update data.';
  } else {
    echo 'Success : Data updated successfully.';
  }
  $db->close();
  return $res;
}
