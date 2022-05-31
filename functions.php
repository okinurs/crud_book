<?php

$conn = mysqli_connect("localhost", "root", "", "bookstore" ); // koneksi ke database


function query($query) {
    global $conn; //agar variabel yang diluar function dapat diakses
    $result = mysqli_query($conn, $query); //ambil data dari seluruh isi dari tabel tb_book
    $rows =[]; //membuat wadah kosong
    while( $row = mysqli_fetch_assoc($result)) { // ambil data dari variabel result dengan tipe data string
        $rows[] = $row; // menambahkan elemen baru di akhir tiap array

    }
    return $rows;
}


function add($data)
{
     global $conn;
      //ambil data dari tiap form
      $judul = htmlspecialchars($data["judul_buku"]);
      $penulis = htmlspecialchars($data["penulis"]);
      $penerbit = htmlspecialchars($data["penerbit"]);
     // upload gambar
     $cover = upload();
     if( !$cover ){
         return false;
     }
      

       //query nsert ke database
    $query = "INSERT INTO tb_book VALUES
    ('', '$judul', '$penerbit', '$penulis',  '$cover')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
  
}

function upload(){

    $namaFile = $_FILES['cover']['name'];
    $ukuranFile =$_FILES['cover']['size'];
    $error = $_FILES['cover']['error'];
    $tmpName = $_FILES['cover']['tmp_name'];

    
// cek apakah ada gambar yang diupload atau tidak
    if( $error === 4 ){
        echo "<script>
            alert('pilih gambar dahulu');
            </script>";
            return false;
    }
    // yang diupload hanya gambar
    $extensiGambarValid = ['jpg', 'jpeg', 'png'];
    $extensiGambar = explode('.', $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));
    if ( !in_array($extensiGambar, $extensiGambarValid) ){
        echo "<script>
            alert('yang anda upload bukan gambar');
            </script>";
            return false;
    }
    // cek ukuran 
    if( $ukuranFile > 100000){
        echo "<script>
            alert('ukuran gambar terlalu besar');
        </script>";
        return false;
    }
    // ganti nama file yang diupload
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensiGambar;

    // jika lulus pengecekan
    move_uploaded_file($tmpName, 'img/'.$namaFileBaru);

    return $namaFileBaru;

}

function delete($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_book WHERE id = $id");

    return mysqli_affected_rows($conn);

}

function update($data){
    global $conn;
    $id = $data["id"];
    $judul = htmlspecialchars($data["judul_buku"]);
    $penulis = htmlspecialchars($data["penulis"]);
    $penerbit = htmlspecialchars($data["penerbit"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek user ganti gambar atau tidak
    if ( $_FILES['cover']['error'] === 4 ){
        $cover = $gambarLama;
    }else{
        $cover = upload();
    }

     //query update ke database
  $query = "UPDATE tb_book SET
                judul_buku = '$judul',
                penerbit = '$penerbit',
                penulis = '$penulis',
                cover = '$cover'
                WHERE id = $id
                ";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}



function search($keyword){
    $query = "SELECT * FROM tb_book
                WHERE
                judul_buku LIKE '%$keyword%' OR
                penulis LIKE '%$keyword%' OR
                penerbit LIKE '%$keyword%' 
                ";

        return query($query);


}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek user sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM tb_users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)){
        echo "<script>
        alert('Username sudah terdaftar!');
        </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
            alert('password tidak sesuai!');
            </script>";
            return false;
    }
    // enkripsi password
    $password = password_hash($password, PASSWORD_BCRYPT);
    // // insert ke database
    mysqli_query($conn, "INSERT INTO tb_users VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);


}

?>