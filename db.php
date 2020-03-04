<?php
class Database{
    private $dns='mysql:host=localhost;dbname=contacts';
    private $username='root';
    private $password='password';
    public $conn;

    public function __construct(){
        try{
            $this->conn=new PDO($this->dns,$this->username,$this->password);
        }
        catch(PDOException $Ex){
            return $Ex->getMessage();
        }
    }
    public function insertcontact($fname,$lname,$email,$phone,$phonecode){
        try{
            $insertStatement='INSERT INTO contacts (FirstName,LastName,Email,Phone,phonecode) VALUES(:fname,:lname,:email,:phone,:phonecode)';
            $insertprepare=$this->conn->prepare($insertStatement);
            $insertprepare->execute(['fname'=>$fname,'lname'=>$lname,'email'=>$email,'phone'=>$phone,'phonecode'=>$phonecode,]);
            if($insertprepare->rowCount()==1){
                return true;
            }else{
                return false;
            }
        }
        catch(PDOException $Ex){
            return false;
        }
    }
    public function showcontacts(){
        try{
            $selectStatement='SELECT * FROM contacts';
            $selectprepare=$this->conn->prepare($selectStatement);
            $selectprepare->execute();
            if($selectprepare->rowCount()>0){
                $selectData=$selectprepare->fetchAll(PDO::FETCH_ASSOC);
                return $selectData;
            }
            else{
                $error='No data Exists';
                return $error;
            }
        }catch(PDOException $Ex){
            $error='Sorry, some problem persists. Cant get data.';
        }
    }
    public function getContactById($id){
        try{
            $selectStatement='SELECT * FROM contacts WHERE id=:id';
            $selectprepare=$this->conn->prepare($selectStatement);
            $selectprepare->execute(['id'=>$id,]);
            if($selectprepare->rowCount()>0){
                $selectData=$selectprepare->fetch(PDO::FETCH_ASSOC);
                return $selectData;
            }
            else{
                $error='No data Exists';
                return $error;
            }
        }catch(PDOException $Ex){
            $error='Sorry, some problem persists. Cant get data.';
        }
    }
    public function updateContact($id,$fname,$lname,$email,$phone,$phonecode){
        try{
            $updateStatement='UPDATE contacts SET FirstName=:fname,LastName=:lname,Email=:email,Phone=:phone,phonecode=:phonecode WHERE id=:id';
            $updateprepare=$this->conn->prepare($updateStatement);
            $updateprepare->execute(['fname'=>$fname,'lname'=>$lname,'email'=>$email,'phone'=>$phone,'phonecode'=>$phonecode,'id'=>$id]);
            return true;
        }
        catch(PDOException $Ex){
            return false;
        }
    }
    public function deletecontact($id){
        try{
            $deleteStatement='DELETE FROM contacts WHERE id=:id';
            $deleteprepare=$this->conn->prepare($deleteStatement);
            $deleteprepare->execute(['id'=>$id]);
            if($deleteprepare->rowCount()>0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(PDOException $Ex){
            return false;
        }
    }
}
?>