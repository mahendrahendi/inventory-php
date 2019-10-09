<?php

require 'config.php';
require 'inc/session.php';
require 'inc/items_core.php';
require 'inc/categories_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');
$_items->set_session_obj($_session);

$_page = 13;




$role = $_session->get_user_role();
if($role != 1 && $role != 2)
	header('Location: items.php');


if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		//if(!isset($_POST['itemid']) || !isset($_POST['name']) || !isset($_POST['desc']) || !isset($_POST['cat']) || !isset($_POST['price']) || !isset($_POST['imageup']))
			//die('wrong');
			
		//if($_POST['itemid'] == '' || $_POST['name'] == '' || $_POST['cat'] == '' || $_POST['price'] == '')
			//die('wrong');
		
		$itemid = $_POST['itemid'];
		$kode = $_POST['desc'];
		$name = $_POST['name'];
		$cat = $_POST['cat'];
		$price = $_POST['price'];
		$imageup = $_POST['imageup'];
	
	
		// Fix price
		$price = (string)$price;
		if(strpos($price, '.') === false) {
			$price = $price.'.00';
		}else{
			$pos = strpos($price, '.');
			if($price{$pos+1} == null)
				$price = $price.'00';
			elseif(!isset($price{$pos+2}))
				$price = $price.'0';
			else
				$price = substr($price,0,$pos+3);
		}
		
		if(substr_count($price, '.') > 1)
			die('wrong');
		
		if($_items->update_item($itemid, $kode, $name, $cat, $price, $imageup) == false)
			die('wrong');
		   die('1');
	}
}



if(!isset($_GET['id']))
	header('Location: items.php');
$itemid = $_GET['id'];

if($_items->get_item_name($itemid) == '')
	header('Location: items.php');

$item = $_items->get_item($itemid);
$idforimg = '999099001';




//


 
 if(!isset($_GET['id']))
	header('Location: items.php');
$itemid = $_GET['id'];

if($_items->get_item_name($itemid) == '')
	header('Location: items.php');

$item = $_items->get_item($itemid);



//

 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 
	

 //checking the required parameters from the request 
 if(isset($_FILES['image']['name'])){
	 
	//$ambil = $_POST['ambil'];
	$itemid2 = $_POST['itemid'];
	$itemName = $_POST['item-name'];
	$itemDesc = $_POST['item-descrp'];
	$imgname = ($_FILES['image']['name']);
 //getting file info from the request 
 $fileinfo = pathinfo($_FILES['image']['name']);
 
 //getting the file extension 
 $extension = $fileinfo['extension'];
 
 

 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))
 	{
        echo 'Unknown image format.';
    }

//jpg-jpeg     
if($extension=="jpg" || $extension=="jpeg" )
    {
        $uploadedfile = $_FILES['image']['tmp_name'];
        $src = imagecreatefromjpeg($uploadedfile);
        list($width,$height)=getimagesize($uploadedfile);
        
        //set new width
        $newwidth1=$width;
        $newheight1=($height/$width)*$newwidth1;
        $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
                
        imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

        //new random name        
        $temp = explode(".", $_FILES["image"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
                
        $filename1 = "img/". $itemid2.".". $extension;
                    
        imagejpeg($tmp1,$filename1,100);
        
        imagedestroy($src);
        imagedestroy($tmp1);
        //insert in database
       $insert=mysqli_query($con, "UPDATE invento_items SET img ='null' where descrp='itemid2';");
	   
	   if($_items->update_item($itemid2, $itemName, $itemDesc, '1', '1', $filename1) == false)
			die('wrong');
		die('1');

        echo "<html>
		<head>
		</head>
		<body>
			<meta http-equiv='REFRESH' content='0 ; url=index.php'>
			<script>
				alert('The image has been uploaded .');
			</script>
		</body>
        </html>";
    }

//png
    else if($extension=="png" || $extension=="PNG")
    {
	
        $uploadedfile = $_FILES['image']['tmp_name'];
        $src = imagecreatefrompng($uploadedfile);
        list($width,$height)=getimagesize($uploadedfile);

        //set new width            
        $newwidth1=$width;
        $newheight1=($height/$width)*$newwidth1;
        $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
                
        imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
        
        //new random name
        $temp = explode(".", $_FILES["image"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
                
        $filename1 = "img/". $itemid2.".". $extension;
                    
        imagejpeg($tmp1,$filename1,100);
        
        imagedestroy($src);
        imagedestroy($tmp1);

        //insert in database
        $insert=mysqli_query($con, "UPDATE invento_items SET img ='null' where descrp='itemid2';");
		if($_items->update_item($itemid2, $itemName, $itemDesc, '1', '1', $filename1) == false)
			die('wrong');
		die('1');

           
    }    
	
	
	  else if($extension=="gif") {
		$uploadedfile = $_FILES['image']['tmp_name'];
		$imgname = ($_FILES['image']['name']);
		//new random name

		$temp = explode(".", $_FILES["image"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
                
		$filename1 = "img/". $itemid2.".". $extension;
		$filename2 = 'gambar23';
		

			//$ambil = $_POST['ambil'];
	$itemid2 = $_POST['itemid'];
	$itemName = $_POST['item-name'];
	$itemDesc = $_POST['item-descrp'];
	
		
	
		move_uploaded_file($uploadedfile,$filename1);

		//insert in database
		// $insert=mysqli_query($con, "INSERT INTO invento_items (img) VALUES ('$filename1');");
		//$insert=mysqli_query($con, "UPDATE invento_items SET img ='null' where descrp='itemid2';");
		
		if($_items->update_item2($itemid2, $itemName, $itemDesc, '1', '1', $filename1) == false)
			if($prepared)
           // header('Location: http://localhost/inv/items.php');
	       echo "Berhasil ditambahkan <a href='http://localhost/inv/items.php'>Click Here to Continue</a>";
		//	die('wrong');
		//die('1');
		
	
	
		
		
		echo "<html>
		<head>
		</head>
		<body>
			<meta http-equiv='REFRESH' content='0 ; url=http://localhost/inv/new-item.php>
			<script>
				alert('The image has been uploaded .');
			</script>
		</body>
        </html>";    

		
		
        
	
	}
	
  }
 }

?>	
<!DOCTYPE HTML>
<html>
<head>
<?php require 'inc/head.php'; ?>
</head>
<body>
	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>
		
		<div class="wrapper-pad">
			<h2>Edit Item (ID <?php echo $itemid; ?>)</h2>
			<div class="center">
				<div class="new-item form">
					<form method="post" action="" name="edit-item"  data-id="<?php echo $itemid; ?>">
						Kode Barang:<br />
						<div class="ni-cont">
							<input type="text" name="item-name" class="ni" value="<?php echo $item->descrp; ?>" />
						</div>
						<input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
						<?php
						$desc = 400 - strlen($item->descrp);
						?>
						<span class="item-desc-left">Nama Barang</span><br />
						<div class="ni-cont">
							<textarea name="item-descrp" class="ni"><?php echo $item->name; ?></textarea>
						</div>
						Category:<br />
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<?php
							if($_cats->count_cats() == 0)
								echo '<select name="item-category" disabled><option val="no">You need to create a category first</option></select>';
							else{
								echo '<select name="item-category">';
								$cats = $_cats->get_cats_dropdown();
								while($catt = $cats->fetch_object()) {
									echo "<option value=\"{$catt->id}\">{$catt->name}</option>";
								}
								echo '</select>';
							}
							?>
							
						</div>
					<!--	Price of each item:<br /> -->
						<input type="hidden" name="item-price" class="ni-small" placeholder="0.00" value="<?php echo $item->price; ?>" />
						<br />
						<div class="ni-cont">
							  <input type="hidden" name="item-imageup" value="<?php echo $item->img; ?>"/>
						</div>	
						<input type="submit" name="item-submit" class="ni btn blue" value="Save changes" />
		
					</form>
				</div>
			</div>
		</div>
		<div class="clear" style="margin-bottom:40px;"></div>
	<form action="edit-item.php" method="post"  enctype="multipart/form-data">
	Tambahkan Gambar:<br />
   	<br /> <input type="file" name="image"/>
	<input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
	<input type="hidden" name="item-name" value="<?php echo $item->name; ?>"/>
	<input type="hidden" name="item-descrp" value="<?php echo $item->descrp; ?>"/>
	<input type="hidden" name="item-cat" value="<?php
						$cat = $_cats->get_cat($item->category);
						echo $cat->name;
						?>"/>
	
    <button type="submit">Upload</button>
    </form>
		<div class="border" style="margin-bottom:30px;"></div>
	</div>

</body>
</html>