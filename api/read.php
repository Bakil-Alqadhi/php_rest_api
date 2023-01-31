<?php 
    //headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
/*The two headers  are commonly used in REST APIs to control access 
and specify the format of the data being sent and received.
*/



// initializing our api
include_once('../core/initialize.php');

// instantiate post
$post = new Post($db);

//blog post query 
$result = $post->read();
//get the row count
$num = $result->rowCount();
if($num > 0){
    $post_arr = array();
    $post_arr['data'] = array();

    while( $row= $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); //is a built-in PHP function that can be used to import variables from an array into the current symbol table.
        /* 
        **When called with an associative array, such as one returned by a FETCH_ASSOC query,
        extract() will create a variable for each key in the array, and assign the corresponding value to it.
        For example, if you have a query result in $row, which is an associative array with keys 'id', 'name' and 'email', 
        you can use the following code:
                extract($row);
                echo $name;\
        This will create three new variables, $id, $name and $email, and assign the corresponding values from the $row array to them.
        */
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );
        array_push($post_arr['data'], $post_item);
        //convert to json and output
        echo json_encode($post_arr);
    }
} else {
    echo json_encode(array('message' => 'No posts found'));
}

?>