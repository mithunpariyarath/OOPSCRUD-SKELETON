<?php
require_once 'db.php';
$db=new DataBase();

//View All Users
if(isset($_POST['action']) && $_POST['action']=='view'){
    $output='';
    $data=$db->showcontacts();
    $i=1;
    foreach($data as $row){
        $output.='
        <tr class="text-left">
            <td>'.$i.'</td>
            <td>'.$row['FirstName'].'</td>
            <td>'.$row['LastName'].'</td>
            <td>'.$row['Email'].'</td>
            <td>'.$row['phonecode'].'-'.$row['Phone'].'</td>
            <td>
                <a href="" class="text-success viewBtnClicked" data-toggle="modal" data-target="#viewContactModal" id="'.$row['id'].'" title="view Contact"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;
                <a href="" data-toggle="modal" data-target="#EditContactModal" class="text-primary editBtnClicked" id="'.$row['id'].'" title="Edit Contact"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                <a href="" class="text-danger deleteBtnClicked" id="'.$row['id'].'" title="Delete Contact"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        ';
        $i++;
    }
    $i=1;
    echo $output;                         
}


//Insert New Contact into Database

if(isset($_POST['action']) && $_POST['action']=='insert'){
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $email=$_POST['addemail'];
    $phone=$_POST['addphone'];
    $phonecode=$_POST['addcountrycode'];
    $output='';
    $data=$db->insertcontact($fname,$lname,$email,$phone,$phonecode);
    if($data){
        echo $output="true";
    }else{
        echo $output="false";
    }

}


//Edit Contact

if(isset($_POST['action']) && $_POST['action']=='edit'){
    $id=$_POST['editId'];
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $email=$_POST['addemail'];
    $phone=$_POST['addphone'];
    $phonecode=$_POST['addcountrycode'];
    $data=$db->getContactById($id);
    $data=json_encode($data);
    echo $data;
}

//Update Contact
if(isset($_POST['action']) && $_POST['action']=='update'){
    $id=$_POST['editId'];
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $email=$_POST['addemail'];
    $phone=$_POST['editphone'];
    $phonecode=$_POST['editcountrycode'];
    $output='';
    $data=$db->updateContact($id,$fname,$lname,$email,$phone,$phonecode);
    if($data){
        echo $output="true";
    }else{
        echo $output="false";
    }
}

//Delete Contact
if(isset($_POST['delete']) && $_POST['delete']=='delete'){
    $del_id=$_POST['delete_id'];
    $data=$db->deletecontact($del_id);
    if($data){
        echo 'true';
    }
    else{
        echo 'false';
    }
}

//View Contact By ID
if(isset($_POST['action']) && $_POST['action']=='viewbyid'){
    $viewbyid=$_POST['viewId'];
    $data=$db->getContactById($viewbyid);
    $data=json_encode($data);
    echo $data;
}

//Export All Contacts to Excel
if(isset($_GET['export']) && $_GET['export']=='excel'){
    $fileName = "contacts-" . date('Ymd') . ".xls";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$fileName");
    header("Pragma: no-cache");
    header("Expires:0");

    $data=$db->showcontacts();
    echo '
    <table border="1px">
        <tr>
            <th>S.No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
         </tr>';
        foreach($data as $row){
            echo '
                <tr>
                    <td>'.$row[id].'</td>
                    <td>'.$row[FirstName].'</td>
                    <td>'.$row[LastName].'</td>
                    <td>'.$row[Email].'</td>
                    <td>'.$row['phonecode'].'-'.$row[Phone].'</td>
                </tr>
            ';
        }
    echo '</table>';
}

?>