<?php 
    //headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//The two headers you mentioned are commonly used in REST APIs to control access and specify the format of the data being sent and received.



// initializing our api
include_once('../core/initialize.php');

// instantiate post
$post = new Post($db);

$post->id = isset($_GET['id']) ? $_GET['id']: die();
$result = $post->read_single($post->id);
$data = $result->fetch(PDO::FETCH_ASSOC);
if($data){
    echo json_encode($data);

} else {
    echo json_encode(array('message' => 'No post found'));
}
// $post_arr = array();
// $post_arr['data'] = array();
// extract($data);
// array_push($post_arr['data'], $data);





?>