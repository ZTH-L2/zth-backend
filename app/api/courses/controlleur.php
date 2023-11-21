<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_courses.php";
require_once "api/db_connect.php";
function option_course($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_course($params){
    $conn = db_connect();
    $id = $params[0];
    $res = select_course($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

function post_course($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();

                // get the data
                if (isset($_POST["name"]) && isset($_POST["subs"]))
                {
                    $name_dirty = $_POST["name"];
                    $subs = $_POST["subs"];
                }
                else
                {
                    invalid_format_data_error_message();
                    return;
                }

                // sanitize the data
                $name = filter_var($name_dirty);

                if (!$name)
                {
                    unsafe_data_error_message();
                    return;
                }
                $res = create_course($conn, $name);
                $id = select_max($conn);
                $id = $id["MAX(`id_course`)"];
                for ($i = 0; $i < count($subs); $i++){
                    $major = filter_var($subs[$i]["id_major"], FILTER_VALIDATE_INT);
                    $year = filter_var($subs[$i]["id_year"], FILTER_VALIDATE_INT);
                    if (!$major || !$year)
                    {
                        unsafe_data_error_message();
                        return;
                    }
                    private_post_majors_courses_link($id, $major, $year);
                }
                if ($res)
                {
                    return success_message_json(201, "201 Created: New course successfully created");
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not create the course");
                }

            }
            else
            {
                no_data_error_message();   
            }
        }
        else
        {
            return permission_denied_error_message();
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}

function del_course($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            $res = delete_course($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted course successfully");
            }
            else
            {
                return success_message_json(200, "200 OK: Deleted nothing but successfull");
            }
        }
        else
        {
            return permission_denied_error_message();
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}

function put_course($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();
            
                // get the data
                if (isset($_POST["name"]) && (isset($_POST["id_course"])))
                {
                    $name_dirty = $_POST["name"];
                    $id_dirty = $_POST["id_course"];
                }
                else
                {
                    invalid_format_data_error_message();
                    return;
                }
            
                // sanitize the data
                $name = filter_var($name_dirty);
                $id = filter_var($id_dirty, FILTER_VALIDATE_INT);
            
            
                if (!$name || !$id)
                {
                    unsafe_data_error_message();
                    return;
                }
                $res = update_course($conn, $name, $id);
                if ($res)
                {
                    return success_message_json(200, "200 OK: Updated course's information successfully.") ;
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not update course's information.");
                }
            }
            else
            {
                no_data_error_message();   
            }
        }
        else
        {
            return permission_denied_error_message();
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}