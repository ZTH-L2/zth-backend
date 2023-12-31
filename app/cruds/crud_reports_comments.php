<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


function select_by_id_comment_offset_amount($conn, $id_comment, $offset, $amount_per_page){
     $stmt = $conn->prepare("SELECT * FROM report_comments WHERE id_comment = ? DESC LIMIT ? OFFSET ?");
     $stmt->bind_param("iii", $id_comment, $amount_per_page, $offset); // "i" indicates integer type
     $stmt->execute();
     $result = $stmt->get_result();
     $reports = $result->fetch_all(MYSQLI_ASSOC);
     $stmt->close();
     return $reports;
}

function select_by_id_user_offset_amount($conn, $id_user, $amount_per_page, $offset){
     $stmt = $conn->prepare("SELECT * FROM report_comments WHERE id_user = ? DESC LIMIT ? OFFSET ?");
     $stmt->bind_param("iii", $id_user, $amount_per_page, $offset); // "i" indicates integer type
     $stmt->execute();
     $result = $stmt->get_result();
     $reports = $result->fetch_all(MYSQLI_ASSOC);
     $stmt->close();
     return $reports;
}

        
        
function create_report_comment($conn, $id_user, $id_comment, $report){

/* fonction pour ajouter / creer un(e) new 'report_comment'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/
     $stmt = $conn->prepare("INSERT INTO `reports_comments`(`id_user`, `id_comment`, `report`) VALUES(?, ?, ?)");
     $stmt->bind_param("iii", $id_user, $id_comment, $report); // "i" indicates integer type
     $res = $stmt->execute();
     $stmt->close();
     return $res;
}
    
        
        
function update_report_comment($conn, $id_user, $id_comment, $report, $id){

/* fonction pour update / modifier un(e) 'report_comment' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `reports_comments` set `id_user`='$id_user', `id_comment`='$id_comment', `report`='$report' WHERE`id_report_comment`=$id";
return mysqli_query($conn, $sql);
}
    


function update_report_comment_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'report_comment' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `reports_comments` set `$parameter_name`='$parameter_value' WHERE `id_report_comment`=$id";
return mysqli_query($conn, $sql);
}
    


function select_report_comment($conn, $id){

/* fonction pour selectionner un(e) 'report_comment' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'report_comment' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `reports_comments` WHERE `id_report_comment`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_report_comment($conn){

/* fonction pour selectionner tous les 'report_comment' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `reports_comments`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_report_comment_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'report_comment' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `reports_comments` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_report_comment($conn, $id){

/* fonction pour supprimer un(e) 'report_comment' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'report_comment' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `reports_comments` WHERE `id_report_comment`=$id";
return mysqli_query($conn, $sql);
}
?>