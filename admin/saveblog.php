<?php

include("../db.php");
extract($_POST);

$picture_name=$_FILES['picture']['name'];
$picture_type=$_FILES['picture']['type'];
$picture_tmp_name=$_FILES['picture']['tmp_name'];
$picture_size=$_FILES['picture']['size'];
if(empty($blog_id)){

if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
{
	if($picture_size<=50000000)
	
        $blog_image=time()."_".$picture_name;
		move_uploaded_file($picture_tmp_name,"../blog_images/".$blog_image);
		
mysqli_query($con,"insert into blog (blog_id, blog_title, blog_contents, blog_image, published, link) values ('$blog_id','$blog_title','$blog_contents','$blog_image','$published','$link')");

echo 1;
}
}else{

	if($picture_tmp_name !=''){
		if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
{
	if($picture_size<=50000000)
	
        $blog_image=time()."_".$picture_name;
		move_uploaded_file($picture_tmp_name,"../blog_images/".$blog_image);
		
mysqli_query($con,"UPDATE blog set blog_id= '$blog_id',
 blog_title= '$blog_title',
 blog_contents= '$blog_contents',
 blog_image= '$blog_image',
 published= '$published',
 link= '$link'");

echo 1;
	}
}else{
    mysqli_query($con,"UPDATE blog set blog_id= '$blog_id',
    blog_title= '$blog_title',
    blog_contents= '$blog_contents',
    published= '$published',
    link= '$link'");
echo 1;
}
}
mysqli_close($con);
