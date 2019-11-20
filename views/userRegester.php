<?php

error_reporting(0);
// get database connection
include_once '../API/config/database.php';

// instantiate product object
include_once '../API/objects/user.php';

//instantiate email function
include_once '../API/utils/Email.php';

//instantiate PDF object
include_once '../API/utils/Pdf.php';









if($_SERVER['REQUEST_METHOD']=="POST") {

    $database = new Database();
    $db = $database->getDBConnection();
    $user = new user($db);
    $email = new Email();


    $userdata = array('firstName'=>"",
                      'lastName' => "",
                      'email'=>"",
                      'phoneNumber'=>"",
                      'education'=>"",
                      'educationlevel' => "",
                      'workingindustry'=>"",
                      'workexperience'=>"");




    $userdata['firstname']=  isset($_POST['firstName']) ? trim(strip_tags(htmlspecialchars($_POST['firstName']))) : '';
    $userdata['lastName']=  isset($_POST['lastName']) ? trim(strip_tags(htmlspecialchars($_POST['lastName']))) : '';
    $userdata['email']=  isset($_POST['email']) ? trim(strip_tags(htmlspecialchars($_POST['email']))) : '';
    $userdata['phoneNumber']=  isset($_POST['phoneNumber']) ? trim(strip_tags(htmlspecialchars($_POST['phoneNumber']))) : '';
    $userdata['education']=  isset($_POST['education']) ? trim(strip_tags(htmlspecialchars($_POST['education']))) : '';
    $userdata['educationlevel']=  isset($_POST['educationlevel']) ? trim(strip_tags(htmlspecialchars($_POST['educationlevel']))) : '';
    $userdata['workingindustry']=  isset($_POST['workingindustry']) ? trim(strip_tags(htmlspecialchars($_POST['workingindustry']))) : '';
    $userdata['workexperience']=  isset($_POST['workexperience']) ? trim(strip_tags(htmlspecialchars($_POST['workexperience']))) : '';

//validate data form data (Backend validation)
    $ok_form=true;
//    fistname validation

    if (empty($userdata["firstname"]))
    {
        $msgE= "Please enter your first name ";
        $ok_form = false;
    }
    else if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/",  $userdata["firstname"]))
    {
        $msgE = "First name is invalid ";
        $ok_form = false;
    }


// last namer validation
    if (empty( $userdata['lastName']))
    {
        $msgE = "Please enter your last name";
        $ok_form = false;
    }
    else if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $userdata['lastName']))
    {
        $msgE = "Last name is invalid ";
        $ok_form = false;
    }

    //contactnumber validation
    if (empty($userdata['phoneNumber']))
    {
        $msgE = "Please enter your contact number ";
        $ok_form = false;
    }
    else if (!is_numeric($userdata['phoneNumber']))
    {
        $msgE = "Contact number is invalid ";
        $ok_form = false;
    } else if(strlen($userdata['phoneNumber'])<10){
        $msgE = "Please enter a valid contact number ";
        $ok_form = false;
    }

//email address validation
    if (empty(  $userdata['email'] ))
    {
        $msgE = "Please enter your email address ";
        $ok_form = false;
    }
    else if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/',   $userdata['email'] ))
    {
        $msgE = "Email address is invalid ";
        $ok_form = false;
    }

//select data validation
    if (empty($userdata['education']))
    {
        $msgE = "Please select educate area ";
        $ok_form = false;
    }
    if (empty($userdata['educationlevel']))
    {
        $msgE = "Please select educate level ";
        $ok_form = false;
    }
    if (empty($userdata['workingindustry']))
    {
        $msgE = "Please select working industry ";
        $ok_form = false;
    }
    if (empty($userdata['workexperience']))
    {
        $msgE = "Please select working experience ";
        $ok_form = false;
    }








    if ($ok_form) {
//    set user property values
        $user->firstName = $userdata['firstname'];
        $user->lastName = $userdata['lastName'];
        $user->email = $userdata['email'];
        $user->phone = $userdata['phoneNumber'];
        $user->educateArea = $userdata['education'];
        $user->educationLevel = $userdata['educationlevel'];
        $user->workingArea = $userdata['workingindustry'];
        $user->workingExperience = $userdata['workexperience'];


// check user exsists

        if($user->read()>0){
            $rest=$user->update();

            if($rest){
                http_response_code(201);
                $MSG="User updated";
            }else{

                // set response code - 503 service unavailable
                http_response_code(503);
                $MSG="User did not updated plese try again";
            }
        }else {

            $dec = $user->decision();
            $user->decision=$dec['decision'];
            $usercreate= $user->create();
            $pdfgenerate=generatepdf($dec['message'],$userdata);
            $email->email=$userdata['email'];

            $email->fname=$userdata['firstname'];

            $email->message=
                'Full Name :	' . $userdata['firstname'] . $userdata['lastName'] . '<br />
                 Subject   :	 new user <br />
                 Phone     :	' . $userdata['phoneNumber'] . '<br />
                 Email     :	' .$userdata['email'] . '<br />
                 Education :	' . $userdata['education'] . '<br />
                 Education Level     :	' . $userdata['educationlevel'] . '<br />
                 Working Industry     :	' . $userdata['workingindustry'] . '<br />
                 Work Experiencel     :	' . $userdata['workexperience'] . '<br /> 
                 Decision :	' . $dec['decision'] . '<br />            
                    ';
            $email->path=$pdfgenerate;

                      
            $email->emailsend();



            if($usercreate){
                http_response_code(201);
                $MSG= "User Created";

            }else{

                // set response code - 503 service unavailable
                http_response_code(503);
                $MSG= "User Did not created";
            }

        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="css/favicon.png">
    <title>Radus28 - user register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->

    <link rel="stylesheet" href="css/jquery-confirm.css">
    <link href="css/dropzone.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery-confirm.css">

    <script src='vendor/jquery/jquery-3.2.1.min.js'></script>


</head>

<body class="bg-light">

<nav class="navbar navbar-light bg-light navbar-fixed-top" style="background-color: #dee5ec !important;">
    <div class="container">
        <div class="col-md-2">
            <img  align="right" class="img-logo" src="css/logo.jpg">
        </div>
        <div class="col-md-10">
            <h1 >Radus28</h1>
        </div>

    </div>
</nav>
<div class="container" style="margin-bottom: 100px">

    <div class="card card-register mx-auto mt-5">
        <div class="card-header"style="text-align: center">User Regestration</div>
        <div class="card-body">
            <p style="text-align: center; color: <?php if (isset($MSG) && $MSG!=""){echo "#387c99";} elseif (isset($msgE) && $msgE!=""){echo "#dc3545";} ?>; font-size: 16px;"><?php if (isset($MSG) && $MSG!=""){echo $MSG;} elseif (isset($msgE) && $msgE!=""){echo $msgE;} ?></p>
            <form id="userregister" method="post">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First name" required="required" autofocus="autofocus">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last name" required="required">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="Email">Email *</label>
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email" required="required">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="Phone Number" required="required">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="education">Education  *</label>
                                <select  id="education" name="education" required >
                                    <option value="default">Select</option>
                                    <option value="Software engineering">Software engineering</option>
                                    <option value="Information Technology">Information Technology</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Computer Applications">Computer Applications</option>
                                    <option value="Others">Others</option>

                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="educationLevel">Education Level *</label>
                                <select  id="educationlevel" name="educationlevel" required >
                                    <option value="default">Select</option>
                                    <option value="Post Graduate">Post Graduate</option>
                                    <option value="Under Graduate">Under Graduate</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Others">Others</option>

                                </select>

                            </div>
                        </div>



                            </div>



                    </div>


                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="workexperience">Work experience *</label>
                                <select  id="workexperience" name="workexperience" required>
                                    <option value="default">Select</option>
                                    <option value="1 Yr">1 Yr</option>
                                    <option value="2 Yrs">2 Yrs</option>
                                    <option value="3 Yrs">3 Yrs</option>
                                    <option value="4 Yrs">4 Yrs</option>
                                    <option value="5 Yrs">5 Yrs</option>
                                    <option value="6 Yrs">6 Yrs</option>
                                    <option value="6 More">More than 6 Yrs</option>
                              </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-label-group">
                                <label for="workingindustry">Working Industry *</label>
                                <select  id="workingindustry" name="workingindustry" required >
                                    <option value="default">Select</option>
                                    <option value="Software Engineering">Software Engineering</option>
                                    <option value="QA Automation">QA Automation</option>
                                    <option value="Database administration">Database administration</option>
                                    <option value="System Administration">System Administration</option>
                                    <option value="Others">Others</option>

                                </select>

                            </div>


                       </div>


                </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" id="reg">Register</button>
                </div>
        </div>





            </form>

        </div>
    </div>


<footer class="sticky-footer" style="    width: 100%;">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright © radus28 2019</span>
        </div>
    </div>
</footer>
</body>
<!-- Bootstrap core JavaScript-->

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Bootstrap core JavaScript-->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<script src="js/jquery.validate.js"></script>
<script src="js/jquery-ui.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/jquery-confirm/jquery-confirm.js"></script>
<script src="vendor/jquery-validate/jquery.validate.js"></script>
<script>
    jQuery(function ($) {
        $.validator.addMethod("valueNotEquals", function(value, element, arg){
            return arg !== value;
        }, "Value must not equal arg.");

        $('#userregister').validate({
            // add the rule here

            rules: {
                firstName:{
                    required: true
                },
                lastName:{
                    required: true
                },
                email :{
                    required: true,
                    email: true
                },
                phoneNumber :{
                    required: true,
                    number: true,
                    minlength:10,
                    maxlength:10
                },
                education:{
                    required: true,
                    valueNotEquals: "default"
                },

                educationlevel:{
                    required: true,
                    valueNotEquals: "default"
                },
                workingindustry:{
                    required: true,
                    valueNotEquals: "default"
                },
                workexperience:{
                    required: true,
                    valueNotEquals: "default"
                }
            },
            messages: {
                firstName:{
                    required:"Please enter the first name"
                },
                lastName:{
                    required:"Please enter the last name"
                },
                email: {
                    required: "Please enter the email address",
                    email: "Please enter a valid email address"
                },
                phoneNumber:{
                    required: "Please enter the company address",
                    number:"Please enter numbers"
                },
                education:{
                    required: "Please select the educated area",
                    valueNotEquals: "select the educated area"

                },
                educationlevel:{
                    required: "Please select the education qualifications",
                    valueNotEquals: "select the education qualifications"

                },

                workingindustry: {
                    required: "please select the working industry",
                    valueNotEquals: "please select the work industry"
                },
                workexperience: {
                    required: "Please enter the work experience",
                    valueNotEquals: "please select the work industry"
                }
            }
        });
    });
</script>





</html>