<?php
mysql_connect('localhost','root','');
mysql_select_db('onefile');   //Database Name

// Function Captcha, panjang 5 digit

function acak(){
$panjangacak = 5;
$base="ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789";
$max=strlen($base)-1;
$acak="";
mt_srand((double)microtime()*1000000);
while (strlen($acak)<$panjangacak){
$acak.=$base{mt_rand(0,$max)};
}
return $acak;
}

// Function tambah 

function tambah(){
            $ca1=$_POST['c1'];
            $ca2=$_POST['c2'];
           
            $id=$_POST['id'];
            $nama=$_POST['nama'];
            $alamat=$_POST['alamat'];
            $telp=$_POST['telp'];
            $sts=$_POST['sts'];

            if($ca1==$ca2){
            $q=mysql_query("insert into onefile values ('$id','$nama','$alamat','$telp', '$sts')") or die (mysql_error());
            if($q){
           
            echo "<h4>Berhasil Menambah Data</h4>";
            }
            }else {
            echo "Captcha Tidak cocok";
            }
}

// Function Update Data

function update(){

            $id=$_POST['id'];
            $nama=$_POST['nama'];
            $alamat=$_POST['alamat'];
            $telp=$_POST['telp'];
            $sts=$_POST['sts'];

            $query=mysql_query("update onefile set  nama='$nama', alamat='$alamat', telp='$telp', sts='$sts' where id='$id' ");
            if ($query){
            header("location:onefile.php");
            }
}

if (isset($_POST['tambah'])){
                        echo tambah();
            }
if (isset($_POST['update'])){
                        echo update();
            }
if (isset($_GET['delete'])){
            $idd=$_GET['delete'];
            mysql_query("delete from onefile where id='$idd'");
}
?>


<html>
<!-- Kita bikin tampilannya menjadi menarik kita buat sebuah CSS.-->
<style type="text/css">
            #capcha{
            color:#000;
            background-color:#CCCCCC;
            font-size:15px;
            }


            #kirim{
            color:#000;
            background-color:#00CC00;
            font-size:15px;
            }


            #tambah{
            color:#000;
            background-color:#FF9900;
            font-size:15px;
            }


            #update{
            color:#000;
            background-color:#00FFCC;
            font-size:15px;
            }


            #edit{
            color:#000;
            background-color:#0066FF;
            font-size:15px;
            }


            #hapus{
            color:#000;
            background-color:#FF0000;
            font-size:15px;
            }
</style>

<title> CRUD One File PHP</title>
<body>

<!-- Ini adalah query untuk menampilkan data -->
<?php
if (isset($_GET['edit'])){
$n = $_GET['edit'];
$z=mysql_query("select * from onefile where id='$n'");
$z1=mysql_fetch_array($z);

echo '
<center>

 <table border="0" cellpadding="8" cellspacing="0">

      <form action="" method="post">
<fieldset>
            <label class="col-sm-2 control-label">ID 
                        <input type="hidden" name="id" value="'.$n.'" />
            <input class="form-control" type="text"  value="'.$z1['id'].'" readonly/></label>
            
            <label class="col-sm-3 control-label">Nama 
            <input class="form-control" type="text" name="nama" value="'.$z1['nama'].'" /></label>

            <label class="col-sm-3 control-label">alamat 
            <input class="form-control" type="text" name="alamat" value="'.$z1['alamat'].'" /></label>
            
            <label class="col-sm-3 control-label">No. Telp
            <input class="form-control" type="text" name="telp" value="'.$z1['telp'].'" /></label>

            <label class="col-sm-3 control-label">Status 
            <select class="form-control" name ="sts" value="'.$z1['sts'].'" />
                  <option value="Hidup">Masih Hidup</option>
                  <option value="Meninggal">Meninggal Dunia</option></select></label>
            
            <br>
            
            <tr>
            <td colspan="2" align="center"><button id="update" type="submit" name="update" value="update" >Update</button></td>
            </tr>
</fieldset>
      </form>
</table>
';
}else{

echo '
<center>

 <table border="0" cellpadding="8" cellspacing="0">

<form action="" method="post">
<fieldset>
            <label class="col-sm-1 control-label">ID 
            <input class="form-control" name="id" type="text"/></label>
            <label class="col-sm-2 control-label">Nama
            <input class="form-control" name="nama" type="text"/></label>
            <label class="col-sm-3 control-label">Alamat
            <input class="form-control" name="alamat" type="text"/></label>
            <label class="col-sm-2 control-label">No. Telp
            <input class="form-control" name="telp" type="text"/></label>
            <label class="col-sm-2 control-label">Status  
            <select class="form-control" name ="sts">
                  <option value="Hidup">Masih Hidup</option>
                  <option value="Meninggal">Meninggal Dunia</option></select></label>
<br>
            <label class="col-sm-3 control-label">Captcha
            <input class="form-control" id="capcha" type="text" name="c1" value="'.acak().'" readonly/>
            <input class="form-control" type="text" name="c2" /></label>
            
            <tr>
            <td colspan="2" align="center"><button id="kirim" type="submit" name="tambah" value="tambah" >Kirim</button></td>
            </tr>
      </fieldset>
</form>

</table>
</center>';
}
?>
<hr>
<center>
<!-- Ini adalah tombol untuk TAMBAH DATA -->
<a  href="onefile.php"><button id="tambah" type="button">Tambah Data</button><a>

<!--Ini adalah tabel untuk menampilkan DATA MAHASISWA dari DATABAS.-->
<table width="100%" border="1">
<tr bgcolor="#0099CC">
            <td><center>No</center></td>
            <td><center>ID</center></td>
    <td><center>Nama</center></td>
    <td><center>alamat</center></td>
    <td><center>No. Telp</center></td>
    <td><center>Status</center></td>
    <td><center>Aksi</center></td>
</tr>
<?php
$a=mysql_query("select * from onefile");
$no = 1;
while ($b=mysql_fetch_array($a)){
?>
<tr>
   <td><center><?php echo $no; ?></center></td>
   <td><center><?php echo $b['id']; ?></center></td>
   <td><center><?php echo $b['nama']; ?></center></td>
   <td><center><?php echo $b['alamat']; ?></center></td>
   <td><center><?php echo $b['telp']; ?></center></td>
   <td><center><?php echo $b['sts']; ?></center></td>
   <td><center><a href="?edit=<?php echo $b['id']; ?>"><button id="edit" type="button">Edit</button></a>
    <a href="?delete=<?php echo $b['id']; ?>"><button id="hapus" type="button">Delete</button></a></center></td>
</tr>
<?php
 $no++;
}
?>
</table>

</center>
</body>
</html>