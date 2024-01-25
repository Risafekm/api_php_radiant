<?php

require 'connection.php';

//error message 

function error422($message){
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}


//delete student

function deleteEduModule($eduModuleparams){
 
    global $conn;

    if(!isset($eduModuleparams['mtest_id'])){
        return error422("Student id not found in url ");
    }elseif($eduModuleparams['mtest_id'] == null){
    return error422("Enter the student id");
    }

    $mtestid = mysqli_real_escape_string($conn, $eduModuleparams['mtest_id']);
    $query = "DELETE FROM `edu_module_tests` WHERE `mtest_id` = $mtestid LIMIT 1";
    $result = mysqli_query($conn ,$query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Student deleted successfully',
        ];
        header("HTTP/1.0 200  success");
        return json_encode($data);

    }else{
        $data = [
            'status' => 404,
            'message' => 'Student not found',
        ];
        header("HTTP/1.0 400  Not found");
        return json_encode($data);
    }


}

//Update Student list

function updateEduModuleList($edumoduleInput, $edumoduleparams)
{
    global $conn;

    if (!isset($edumoduleparams['mtest_id'])) {
        return error422('student id not found in url');
    } elseif ($edumoduleparams['mtest_id'] == null) {
        return error422('Enter the student id');
    }

    $mtestId = mysqli_real_escape_string($conn, $edumoduleparams['mtest_id']);
    $modnum = mysqli_real_escape_string($conn, $edumoduleInput['mod_num']);
    $userid = mysqli_real_escape_string($conn, $edumoduleInput['user_id']);
    $mtestpoints = mysqli_real_escape_string($conn, $edumoduleInput['mtest_points']);
    $status = mysqli_real_escape_string($conn, $edumoduleInput['status']);

    if (empty(trim($modnum))) {
        return error422('Enter the modnum');
    } elseif (empty(trim($userid))) {
        return error422('Enter the userid');
    } elseif (empty(trim($mtestpoints))) {
        return error422('Enter the mtestpoints');
    } else {

        $query = "UPDATE `edu_module_tests` SET `mod_num` = '$modnum', `user_id` ='$userid' , `mtest_points` = '$mtestpoints' WHERE `mtest_id` = '$mtestId' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result) {

            $data = [
                'status' => 200,
                'message' => 'Student Created Successfully',
            ];
            header("HTTP/1.0 200 Created");
            echo json_encode($data);

        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        }
    }
}


//postFunction

function storeEduModuleList($edumoduleInput){

    global $conn;

    $modnum = mysqli_real_escape_string($conn, $edumoduleInput['mod_num']);
    $userid = mysqli_real_escape_string($conn, $edumoduleInput['user_id']);
    $mtestpoints = mysqli_real_escape_string($conn, $edumoduleInput['mtest_points']);
    $status = mysqli_real_escape_string($conn, $edumoduleInput['status']);
    

    if(empty(trim($modnum))){
     return error422('Enter the modnum');
    }elseif(empty(trim($userid))){
        return error422('Enter the userid');
    }elseif(empty(trim($mtestpoints))){
        return error422('Enter the mtestmodules');
    }
    else{

       $query = "INSERT INTO `edu_module_tests`(`mod_num`, `user_id`,`mtest_points`,`status`) VALUES ('$modnum','$userid','$mtestpoints','$status')";
       $result = mysqli_query($conn, $query);

     if($result){
  
        $data = [
            'status' => 201,
            'message' => 'eduModuleList Created Successfully',
        ];
        header("HTTP/1.0 201 Created");
        echo json_encode($data);
         

     }else{
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode($data);
     }

    }

}


//getFunction

function geteduModuleList(){
 
global $conn;

$query = "SELECT * FROM `edu_module_tests`";
$query_run = mysqli_query($conn ,$query);

if($query_run){

if(mysqli_num_rows($query_run) > 0){

$res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);

$data = [
    'status' => 200,
    'message' => 'Student List Fetched Successfully',
     'data' => $res
];
header("HTTP/1.0 200  Success");
return json_encode($data);

}else{
    $data = [
        'status' => 404,
        'message' => 'No Student Found',
    ];
    header("HTTP/1.0 404  No Student Found");
    return json_encode($data);
}

}else{
    $data = [
        'status' => 500,
        'message' => 'Internal Server Error',
    ];
    header("HTTP/1.0 500  Internal Server Error");
    return json_encode($data);
}

}

function geteduModule($eduModuleparams){

global $conn;


if($eduModuleparams['mtest_id'] == null){
    return error422('Enter your id');
   }

$edumoduleId = mysqli_real_escape_string($conn, $eduModuleparams['mtest_id']);

$query = "SELECT * FROM `edu_module_tests` WHERE `mtest_id` = '$edumoduleId' LIMIT 1";
$result = mysqli_query($conn,$query);

if($result){

 if(mysqli_num_rows($result) == 1){
 
    $res = mysqli_fetch_assoc($result);
    $data = [
        'status' => 200,
        'message' => 'Edumodule Fetched Successfully',
        'data' => $res
    ];
    header("HTTP/1.0 200  Success");
    return json_encode($data);


 }else{
 $data = [
        'status' => 404,
        'message' => 'No Edumodules Found',
    ];
    header("HTTP/1.0 404  Not found");
    return json_encode($data);
 }

}else{
    $data = [
        'status' => 500,
        'message' => 'Internal Server Error',
    ];
    header("HTTP/1.0 500  Internal Server Error");
    return json_encode($data);
}

}

?>