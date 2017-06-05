<?php
	class DbConnect
	{
		public function connect()
		{
			$servername="localhost";
			$username="root";
			$password="";
			$dbname="fypdb";
			
			try
			{
				$conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				return $conn;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
	}
?>