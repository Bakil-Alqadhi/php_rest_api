<?php 
    //headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-width');



// initializing our api
include_once('../core/initialize.php');

// instantiate post
$post = new Post($db);

$post->id = isset($_GET['id']) ? $_GET['id']: die();
if($post->delete()){
    echo json_encode(
        array('message' => 'Post Has Been Deleted Successfully.')
    );
} else {
    echo json_encode(
        array('message' => "Post did't Delete Successfully.")
    );
}





?>