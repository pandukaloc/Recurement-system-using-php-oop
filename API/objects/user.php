<?php

class user{
   // database connection and table name
    private $conn;
    private $table_name = "user";

    // object properties

    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $educateArea;
    public $educationLevel;
    public $workingArea;
    public $workingExperience;
    public $decision;

    // constructor with $db as database connection
    public function __construct($db)
    { $this->conn = $db;
    }

// read user
    function read(){
        // select all query
        $query = "SELECT
                firstName,lastName,email,phone,educatearea,educationqul,workArea,wrokExperience
            FROM
                " . $this->table_name . " p
                WHERE email=:email ";
        $stmt = $this->conn->prepare($query);
        $this->email=htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);



        if($stmt-> execute()){

            return $stmt->rowcount();
        }else{
            return $stmt->rowcount();
        }


            }

// create User
    function create(){

        // query to insert record
        $query = "INSERT INTO ".$this->table_name."(firstName,lastName,email,phone,educatearea,educationqul,workArea,wrokExperience,decision) 
                 VALUES(:fname,:lmane,:email,:con,:educatearea,:equl,:warea,:wexp,:decs) ";



        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->firstName=htmlspecialchars(strip_tags( $this->firstName));
        $this->lastName=htmlspecialchars(strip_tags($this->lastName));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->educateArea=htmlspecialchars(strip_tags($this->educateArea));
        $this->educationLevel=htmlspecialchars(strip_tags($this->educationLevel));
        $this->workingArea=htmlspecialchars(strip_tags($this->workingArea));
        $this->workingExperience=htmlspecialchars(strip_tags($this->workingExperience));
        $this->decision=htmlspecialchars(strip_tags($this->decision));


        // bind values
        $stmt->bindParam(":fname",  $this->firstName);
        $stmt->bindParam(":lmane", $this->lastName);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":con", $this->phone);
        $stmt->bindParam(":educatearea", $this->educateArea);
        $stmt->bindParam(":equl", $this->educationLevel);
        $stmt->bindParam(":warea", $this->workingArea);
        $stmt->bindParam(":wexp", $this->workingExperience);
        $stmt->bindParam(":decs", $this->decision);


        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }



//user update
function update(){

        $query=" UPDATE ".$this->table_name." SET
             firstName=:fname, 
             lastName=:lmane, 
             email=:email, 
             phone=:con ,
             educatearea=:educatearea, 
             educationqul=:equl, 
             workArea=:warea, 
             wrokExperience=:wexp,
             modifiedDate= NOW()
             WHERE email = :email";
    //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->firstName=htmlspecialchars(strip_tags( $this->firstName));
        $this->lastName=htmlspecialchars(strip_tags($this->lastName));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->educateArea=htmlspecialchars(strip_tags($this->educateArea));
        $this->educationLevel=htmlspecialchars(strip_tags($this->educationLevel));
        $this->workingArea=htmlspecialchars(strip_tags($this->workingArea));
        $this->workingExperience=htmlspecialchars(strip_tags($this->workingExperience));
        $this->decision=htmlspecialchars(strip_tags($this->decision));

    //bind new values
   $stmt->bindParam(":fname",  $this->firstName);
        $stmt->bindParam(":lmane", $this->lastName);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":con", $this->phone);
        $stmt->bindParam(":educatearea", $this->educateArea);
        $stmt->bindParam(":equl", $this->educationLevel);
        $stmt->bindParam(":warea", $this->workingArea);
        $stmt->bindParam(":wexp", $this->workingExperience);
        $stmt->bindParam(":decs", $this->decision);

        //execute the query

    if ($stmt->execute()){
        return true;
    }
return false;
    }

    function decision(){
        $experience=$this->workingExperience;
        $experience= explode(" ",$experience);



        $returnval=array('decision'=>"",'message'=>"");
        if($this->educateArea=="Others"&&$this->educationLevel=="Others"&&$this->workingArea=="Others"&&$experience[0]<4){
            $returnval['decision']='Failed';
        }else{
            $returnval['decision']="Sort Listed";
        }




        $message = '<hr><br>Dear <b>'.$this->firstName.' '.$this->lastName.'</b>';
        $message.='<br><br>';
        $message.='You application was processed. According to your qualifications and skills you are <b>'.$returnval['decision']. '</b> for
the current opportunity at our organization';
        $message.='<br><br><br>';
        $message.='Cheers <br>Managing Director <br>Radus28';
        $returnval['message']=$message;

return $returnval;







    }


}
