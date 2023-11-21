<?php
header('Access-Control-Allow-Origin: *');

require_once "api/utils/utils.php";
require_once "cruds/crud_majors.php";
require_once "api/db_connect.php";
require_once "api/majors_courses_link/controlleur.php";
function option_major($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_major($params){
    $conn = db_connect();
    $id = $params[0];
    $res = select_major($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

function get_major_name($id_major){
    $conn = db_connect();
    $res = select_major($conn, $id_major);
    return $res["name"];
}
function post_major($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();

                // get the data
                if (isset($_POST["name"]))
                {
                    $name_dirty = $_POST["name"];
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
                $res = create_major($conn, $name);
                if ($res)
                {
                    return success_message_json(201, "201 Created: New major successfully created");
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not create the major");
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

function del_major($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            delete_major($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted major successfully");
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

function put_major($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();
            
                // get the data
                if (isset($_POST["name"]) && (isset($_POST["id_major"])))
                {
                    $name_dirty = $_POST["name"];
                    $id_dirty = $_POST["id_major"];
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
            
                $res = update_major($conn, $name, $id);
                if ($res)
                {
                    return success_message_json(200, "200 OK: Updated major's information successfully.") ;
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not update major's information.");
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