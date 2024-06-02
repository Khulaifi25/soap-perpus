<?php

require_once('koneksi.php');
require_once('lib/nusoap.php');
$server = new nusoap_server();

/* Method insert buku baru */
function insertBook($title, $author_name, $publish, $isbn, $category)
{
  global $dbconn;
  $sql_insert = "insert into books (title, author_name, publish, isbn, category) values ( :title, :author_name, :publish, :isbn, :category)";
  $stmt = $dbconn->prepare($sql_insert);
  // insert a row
  $result = $stmt->execute(array(':title' => $title, ':author_name' => $author_name, ':publish' => $publish, ':isbn' => $isbn, ':category' => $category));
  if ($result) {
    return json_encode(array('status' => 200, 'msg' => 'success'));
  } else {
    return json_encode(array('status' => 400, 'msg' => 'fail'));
  }
  $dbconn = null;
}
/* Cari 1 data buku 'Judul' */
function getBookbyTitles($title)
{
  global $dbconn;
  $sql = "SELECT id, title, author_name, publish, isbn, category FROM books 
	        where title LIKE :title";
  // Menyiapkan kueri SQL dan mengikat parameter
  $stmt = $dbconn->prepare($sql);
  // Menambahkan wildcard (%) di kedua sisi nilai judul
  $title = "%" . $title . "%";
  $stmt->bindParam(':title', $title);
  // Menjalankan kueri
  $stmt->execute();
  // Mengambil hasil kueri
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  return json_encode($data);
  $dbconn = null;
}

// function delete data
/* Hapus data buku berdasarkan ID */
function deleteBook($id)
{
  global $dbconn;
  $sql_delete = "DELETE FROM books WHERE id = :id";
  $stmt = $dbconn->prepare($sql_delete);
  $result = $stmt->execute(array(':id' => $id));
  if ($result) {
    return json_encode(array('status' => 200, 'msg' => 'success'));
  } else {
    return json_encode(array('status' => 400, 'msg' => 'fail'));
  }
  $dbconn = null;
}

//function getAllBook
/* Ambil semua data buku */
function getAllBook()
{
  global $dbconn;
  $sql = "SELECT id, title, author_name, publish, isbn, category FROM books";
  $stmt = $dbconn->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return json_encode($data);
  $dbconn = null;
}

// Update Book
function updateBook($id, $title, $author_name, $publish, $isbn, $category)
{
  global $dbconn;
  $sql_update = "UPDATE books SET title = :title, author_name = :author_name, publish = :publish, isbn = :isbn, category = :category WHERE id = :id";
  $stmt = $dbconn->prepare($sql_update);
  $result = $stmt->execute(array(':id' => $id, ':title' => $title, ':author_name' => $author_name, ':publish' => $publish, ':isbn' => $isbn, ':category' => $category));
  if ($result) {
    return json_encode(array('status' => 200, 'msg' => 'success'));
  } else {
    return json_encode(array('status' => 400, 'msg' => 'fail'));
  }
  $dbconn = null;
}


$server->configureWSDL('Web Service', 'urn:book');
$server->register(
  'getBookbyTitles',
  array('title' => 'xsd:string'),  //parameter
  array('data' => 'xsd:string'),  //output
  'urn:book',   //namespace
  'urn:book#getBookbyTitles' //soapaction
);
$server->register(
  'insertBook',
  array('title' => 'xsd:string', 'author_name' => 'xsd:string', 'publish' => 'xsd:string', 'isbn' => 'xsd:string', 'category' => 'xsd:string'),  //parameter
  array('data' => 'xsd:string'),  //output
  'urn:book',   //namespace
  'urn:book#insertBook' //soapaction
);
$server->register(
  'deleteBook',
  array('id' => 'xsd:int'),  //parameter
  array('data' => 'xsd:string'),  //output
  'urn:book',   //namespace
  'urn:book#deleteBook' //soapaction
);
// Get All Data
$server->register(
  'getAllBook',
  array(),  //parameter
  array('data' => 'xsd:string'),  //output
  'urn:book',   //namespace
  'urn:book#getAllBook' //soapaction
);

// Update Book
$server->register(
  'updateBook',
  array('id' => 'xsd:int', 'title' => 'xsd:string', 'author_name' => 'xsd:string', 'publish' => 'xsd:string', 'isbn' => 'xsd:string', 'category' => 'xsd:string'),  //parameter
  array('data' => 'xsd:string'),  //output
  'urn:book',   //namespace
  'urn:book#updateBook' //soapaction
);
$server->service(file_get_contents("php://input"));
