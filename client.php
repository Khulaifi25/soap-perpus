<?php
/*  
	  ini_set('display_errors', true);
	  error_reporting(E_ALL); 
	 */
require_once('lib/nusoap.php');
$error  = '';
$result = array();
$response = '';
$wsdl = "http://localhost:8080/soap-perpus/server.php?wsdl";

// Cari Buku berdasarkan Title/Judul
if (isset($_POST['sub'])) {
	$title = trim($_POST['isbn']);
	if (!$title) {
		$error = 'Title cannot be left blank.';
	}

	if (!$error) {
		// Pemanggilan method pada server SOAP untuk mencari buku berdasarkan judul
		//create client object
		$client = new nusoap_client($wsdl, true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2>' . $err;
			// At this point, you know the call that follows will fail
			exit();
		}
		try {
			$result = $client->call('getBookbyTitles', array('%' . $title . '%'));
			$result = json_decode($result);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}

/* Tambah Buku Baru **/
if (isset($_POST['addbtn'])) {
	// Pengambilan data buku baru dari form
	$title = trim($_POST['title']);
	$isbn = trim($_POST['isbn']);
	$author = trim($_POST['author']);
	$category = trim($_POST['category']);
	$publish = trim($_POST['publish']);

	// Validasi semua kolom tidak boleh kosong
	if (!$isbn || !$title || !$author || !$category || !$publish) {
		$error = 'All fields are required.';
	}

	if (!$error) {
		// Pemanggilan method pada server SOAP untuk menambahkan buku baru
		$client = new nusoap_client($wsdl, true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2>' . $err;
			// At this point, you know the call that follows will fail
			exit();
		}
		try {
			/** Call insert book method */
			$response =  $client->call('insertBook', array($title, $author, $publish, $isbn, $category));
			$response = json_decode($response);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}

// Delete Buku berdasarkan id
if (isset($_POST['book_id'])) {
	$id = $_POST['book_id'];
	//create client object
	$client = new nusoap_client($wsdl, true);
	$err = $client->getError();
	if ($err) {
		echo '<h2>Constructor error</h2>' . $err;
		exit();
	}
	try {
		$response =  $client->call('deleteBook', array($id));
		$response = json_decode($response);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

// Get All Data
if (isset($_POST['alls'])) {
	//create client object
	$client = new nusoap_client($wsdl, true);
	$err = $client->getError();
	if ($err) {
		echo '<h2>Constructor error</h2>' . $err;
		exit();
	}
	try {
		$result = $client->call('getAllBook');
		$result = json_decode($result);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

// Update Book
if (isset($_POST['update'])) {
	$id = $_POST['update'];
	$title = $_POST['title'];
	$author = $_POST['author'];
	$publish = $_POST['publish'];
	$isbn = $_POST['isbn'];
	$category = $_POST['category'];

	// Validasi semua kolom tidak boleh kosong
	if (!$isbn || !$title || !$author || !$category || !$publish) {
		$error = 'All fields are required.';
	}

	if (!$error) {
		// Pemanggilan method pada server SOAP untuk mengupdate buku
		$client = new nusoap_client($wsdl, true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2>' . $err;
			exit();
		}
		try {
			/** Call update book method */
			$response = $client->call('updateBook', array($id, $title, $author, $publish, $isbn, $category));
			$response = json_decode($response);
			if ($response->status == 200) {
				// Success message
				$success_msg = 'Book updated successfully.';
			} else {
				// Error message
				$error_msg = 'Failed to update book. Please try again.';
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>SOAP | Perpustakaan</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512'%3E%3Cpath fill='%23000' d='M568 0H72C32.3 0 0 32.3 0 72v368c0 39.7 32.3 72 72 72h496c39.7 0 72-32.3 72-72V72c0-39.7-32.3-72-72-72zm-40 400H112V64h416v336z'/%3E%3C/svg%3E" type="image/svg+xml">
</head>

<body>
	<div class="container mt-4">
		<h1 class="text-center"><b>SOAP | PERPUSTAKAAN</b></h1>
		<hr>
		<div class="title-head d-flex flex-row-reverse">
			<p>Tulis <strong>Judul Buku</strong> dan klik tombol <strong>Cari</strong></p>
		</div>
		<div class='row ml-1 d-flex flex-row-reverse'>
			<form class="form-inline" method='post' name='form1'>
				<?php if ($error) { ?>
					<div class="alert alert-danger fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong>&nbsp;<?php echo $error; ?>
					</div>
				<?php } ?>
				<div class="form-group">
					<label for="email">Judul Buku :</label>
					<input type="text" class="form-control ml-3" name="isbn" id="isbn" placeholder="Tulis Judul" required>
				</div>
				<button type="submit" name='sub' class="btn btn-primary ml-4 rounded-pill"><i class="fas fa-search"></i>&nbsp; Cari</button>
			</form>
		</div>

		<br>
		<div class='row ml-1 d-flex flex-row'>
			<h2>Tambah Buku</h2>
			<?php if (isset($response->status)) {
				if ($response->status == 200) { ?>
					<div class="alert alert-success fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Success!</strong>&nbsp; Book Added succesfully.
					</div>
				<?php } elseif (isset($response) && $response->status != 200) { ?>
					<div class="alert alert-danger fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong>&nbsp; Cannot Add a book. Please try again.
					</div>
			<?php }
			}
			?>
			<form class="form-inline" method='post' name='form1'>
				<?php if ($error) { ?>
					<div class="alert alert-danger fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong>&nbsp;<?php echo $error; ?>
					</div>
				<?php } ?>
				<div class="form-group mt-3">
					<label for="email"></label>
					<input type="text" class="form-control mr-2" name="title" id="title" placeholder="Judul Buku" required>
					<input type="text" class="form-control mr-2" name="author" id="author" placeholder="Pengarang" required>
					<input type="text" class="form-control mr-2" name="publish" id="publish" placeholder="Penerbit" required>
					<input type="text" class="form-control mr-2" name="isbn" id="isbn" placeholder="ISBN" required>
					<input type="text" class="form-control mr-2" name="category" id="category" placeholder="Kategori" required>
				</div>
				<button onclick="return confirm('Yakin ingin menambahkan data ini?')" type="submit" name='addbtn' class="btn btn-primary mt-3 rounded-pill"><i class="fas fa-plus"></i>&nbsp; Tambah Buku</button>
			</form>
		</div>
		<br>
		<!-- tombol show all data -->
		<div class="row ml-1 d-flex flex-row-reverse">
			<form method="post">
				<button type="submit" name='alls' class="btn btn-primary mt-4 rounded-pill"><i class="fas fa-arrow-circle-down"></i>&nbsp; Tampilkan Semua Data</button>
			</form>
		</div>
		<h2>Informasi Buku</h2>
		<table class="table mb-5">
			<thead>
				<tr>
					<th>No</th>
					<th>Judul Buku</th>
					<th>Pengarang</th>
					<th>Penerbit</th>
					<th>ISBN</th>
					<th>Kategori</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// Inisialisasi variabel nomor urutan
				$no = 1;

				// "Tampilkan Semua Data" ditekan
				if (isset($_POST['alls'])) {
					foreach ($result as $book) { ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $book->title; ?></td>
							<td><?php echo $book->author_name; ?></td>
							<td><?php echo $book->publish; ?></td>
							<td><?php echo $book->isbn; ?></td>
							<td><?php echo $book->category; ?></td>

						</tr>
					<?php }
				} else { ?>
					<?php
					// Jika hasil pencarian tunggal by Judul dan Update
					if ($result) { ?>
						<form action="" method="post">
							<tr>
								<td><?php echo $no++; ?></td>
								<td><input type="text" class="form-control mr-2 mx-auto" name="title" id="title" disabled value="<?php echo $result->title; ?>">
								</td>
								<td><input type="text" class="form-control mr-2 mx-auto" name="author" id="author" disabled value="<?php echo $result->author_name; ?>">
								</td>
								<td><input type="text" class="form-control mr-2 mx-auto" name="publish" id="publish" disabled value="<?php echo $result->publish; ?>">
								</td>
								<td><input type="text" class="form-control mr-2 mx-auto" name="isbn" id="isbn" disabled value="<?php echo $result->isbn; ?>">
								</td>
								<td><input type="text" class="form-control mr-2 mx-auto" name="category" id="category" disabled value="<?php echo $result->category; ?>">
								</td>
								<td><button type="button" onclick="enableForm()" class="btn btn-primary rounded-pill"><i class="fas fa-edit"></i></button></td>
								<td class="border-0">
									<form method="post">
										<input type="hidden" name="update" value="<?php echo $result->id; ?>">
										<button type="submit" class="btn btn-dark rounded-pill" onclick="updatemsg()"><i class="fas fa-sync"></i></button>
									</form>
								</td>
								<td class="border-0">
									<form method="post">
										<input type="hidden" name="book_id" value="<?php echo $result->id; ?>">
										<button type="submit" class="btn btn-danger rounded-pill" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
									</form>
								</td>
							</tr>
						</form>
				<?php }
				} ?>
			</tbody>
		</table>
	</div>
	<script>
		function enableForm() {
			// Get all input fields
			var inputs = document.querySelectorAll('input[type="text"]');

			// Loop through each input and remove the disabled attribute
			inputs.forEach(function(input) {
				input.removeAttribute('disabled');
			});
		}

		function updatemsg() {
			alert("Are you sure you want to update this book?");
		}
	</script>
</body>

</html>