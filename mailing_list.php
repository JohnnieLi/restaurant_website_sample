<?php
include ('./header.php');
require_once('./dao/customerDao.php');
require_once('./websiteUser.php');

session_start();
session_regenerate_id(false);

if(isset($_SESSION['AdminID'])){
   if(!$_SESSION['websiteUser']->isAuthenticated()){
      header('Location:login.php'); 
    }
} else {
    header('Location:login.php');
}


 
$customerDao = new customerDao;
$customers=$customerDao->getCustomers();
//echo '<pre>'. $customers[0].'/<pre>';
echo '<div>'.'SessionID: ' . session_id() .'</div>';
echo '<div>'.'Session AdminID: ' . $_SESSION['AdminID'].'</div>';
if($_SESSION['websiteUser']->getDate()!=null){
echo '<div>'.'Last login date: ' . $_SESSION['websiteUser']->getDate().'</div>';
}else{
echo '<div>'.'The first time to log in' .'</div>';  
}

if ($customers){
    
    echo '<table border=\'1\'>';
                echo '<tr><th>Customer</th> <th>Phone</th> <th>EamilAddress</th> <th>referral</th></tr>';
                $ID = $customerDao->getID();               
                $i=0;
                foreach($customers as $customer){
                    echo '<tr>';
                   // echo '<td>' . $ID[$i] . '</td>';
                  //  echo '<td><a href=\'edit_employee.php?employeeId='. $ID . '\'>' . $ID . '</a></td>';
                    echo '<td>' . $customer->getName() . '</td>';
                    echo '<td>' . $customer->getPhone() . '</td>';
                    echo '<td>' . $customer->getEmail() . '</td>';
                    echo '<td>' . $customer->getReferrer() . '</td>';
                    echo '</tr>';
                    $i++;
                }
                echo '</table>';
                echo '<a href="logout.php" style="color:red;">Logout!</a>';
}else{
    echo '<h3>'.'No mailing exist now'.'</h3>';
    echo '<a href="logout.php" style="color:red;">Logout!</a>';
}


?>

<?php include './footer.php' ?>