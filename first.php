
<html>

<head>
<title>Test PhP</title>
</head>

<body>

<?php

$sname=$_POST["Sname"];
$dd=$_POST["dd"];
$mm=$_POST["mm"];
$yy=$_POST["yy"];
$sex=$_POST["sex"];
$roll=$_POST["rno"];
$mail=$_POST["email"];
$sch=$_POST["school"];
$osch=$_POST["oschool"];
$pass=$_POST["pwd"];
$rpass=$_POST["rpwd"];
$club=$_POST["club"];
$ci="";
$check=0;

echo "<ul>";
  if($sname=="")
   {  echo "<li>Name cannot be blank</li>";
      $check=1;    
   }
  else if(strtoupper($sname[0])!=$sname[0])
   {  echo "<li>First letter of name must me uppercase</li>";
      $check=1;
   }
   
   /*Date*/
   if($dd=="" || $mm=="" || $yy=="")
   {  echo "<li>Date cannot be blank</li>";
      $check=1;
   }
   else
   {
    if($yy>2013 || $yy<1950 || $mm>12)
    {  echo "<li>Invalid date</li>";
       $chk=1;
    }
	if($mm%2==0)
	{
	  if($mm<7 && $dd>30)
        { echo "<li>Invalid Date</li>";
	      $check=1;
		}
	   if($mm>7 && $dd>31)
 	    { echo "<li>Invalid Date</li>";
	      $check=1;
		}
	   if($mm==2 && $dd>28 && $yy%4!=0 || $mm==2 && $dd>29 && $yy%4==0)
	    { echo "<li>Invalid Date</li>";
	      $check=1;
	    }	  
	}
	if($mm%2!=0 && $mm<=7 && $dd>31 || $mm%2!=0 && $mm>7 && $dd>30)
	{  echo "<li>Invalid Date</li>";
	   $check=1;
	}   
   }
   
   /*Roll No.*/
	if($roll=="")
	{  echo "<li>Roll No. cannot be blank</li>";
	   $check=1;
	}   
	else if(strlen($roll)!=10)
	{  echo "<li>Roll No. must have 10 digits</li>";
	   $check=1;
	}   

   /*E-Mail*/
    if(!filter_var($mail,FILTER_VALIDATE_EMAIL))
    {  echo "<li>Invalid email</li>";
  	   $check=1;
	}

   /*Clubs*/
    if(isset($_POST["club"]))
    {  $club=$_POST["club"];
	   if(count($club)<3)
       {  echo "<li>Atleast 3 clubs must be selected</li>";
	   $check=1;
	   }
	}   
	else
	{  echo "<li>Atleast 3 clubs must be selected</li>";
	   $check=1;
	}
	
   /*Password*/
    $rege=array(
	  "options"=>array("regexp"=>"/[^A-z0-9_]+/")
	);	    
    if($pass=="")
	{  echo "<li>Password must not be blank</li>";
	   $check=1;
	}
	else if(strlen($pass)<5 || strlen($pass)>10)
	{  echo "<li>Password must be 5-10 characters long</li>";
	   $check=1;
	}
    else if(filter_var($pass,FILTER_VALIDATE_REGEXP,$rege))
	{  echo "<li>Password must contain only A-Z/a-z/0-9/_</li>";
	   $check=1;
	}
    if($rpass=="")
    {  echo "<li>Please repeat password	</li>";
	   $check=1;
	}
    else if($rpass!=$pass)
    {  echo "<li>Passwords do not match</li>";
       $check=1;
	}   
	

   /*Photo*/
   if($_FILES["photo"]["name"]!="")
   {$allowedExts = array( "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["photo"]["name"]);
    $extension = end($temp);
    if ((($_FILES["photo"]["type"]=="image/jpeg") || ($_FILES["photo"]["type"]=="image/png")) && in_array($extension, $allowedExts))
    {  if($_FILES["photo"]["size"] > 1000000)
	    {  echo"</li>Image size must be less than 1MB</li>";
           $check=1;
		}
	}	
    else
    {  echo "<li>Image format must be.jpg/.png</li>";
       $check=1;
    }
   } 	
echo "</ul>";

if($check==0)
{  echo "<h1>Successfully Registered!</h1>";
   $con=mysqli_connect("localhost","root","ab123","anupam");
   if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  else
  { echo "Success!!";  }
  
  for($i=0;$club[$i];$i++)
  { global $ci;
    $ci=$ci."$club[$i]"." ";
  }
  
  if($sch=="oth")
  {  $sch=$osch;  }
  
  $pass=crypt($pass,'$5$rounds=5000sf5yf456z4zab84bz68f5b4z684');
  
  $pic=fopen($_FILES["photo"]["name"],'r');
 
  $cmd="INSERT INTO logindetails (addr,club,dept,dob,gender,mail,Name,pass,roll,school,pic)
  VALUES ('$_POST[addr]','$ci','$_POST[dep]','{$yy}-{$mm}-{$dd}','$sex','$mail','$sname','$pass','$roll','$sch','$pic')";
  

  
  mysqli_query($con,$cmd);
  
  			   



 }  
?>  
</body>

</html>
