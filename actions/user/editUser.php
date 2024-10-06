<?php
    ob_start();
    require_once(__DIR__ . '/../../utils/session.php');
    require_once(__DIR__ . '/../../database/connection.db.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['csrfToken']) && isset($_SESSION['csrf']) && $_POST['csrfToken'] === $_SESSION['csrf']) {

            $selected_deps = $_POST['tags'] ?? [];
            $user_type = $_POST['user_type'];
            $idUser = $_POST['idUser'];

            if ($user_type == "Client") {            
                $query = "DELETE FROM assUserDepartment WHERE user_id = :idUser";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':idUser', $idUser);
                $stmt->execute();
            
            }
            
            else{

                $query = "SELECT department_id FROM assUserDepartment WHERE user_id = :idUser";
                $statement = $db->prepare($query);
                $statement->bindValue(':idUser', $idUser);
                $statement->execute();
                $existing_departments = $statement->fetchAll(PDO::FETCH_COLUMN);

                $deps_to_remove = array_diff($existing_departments, $selected_deps);

                if (!empty($deps_to_remove)) {
                    $query = "DELETE FROM assUserDepartment WHERE user_id = :idUser AND department_id IN (".implode(',', $deps_to_remove).")";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':idUser', $idUser);
                    $statement->execute();
                }


                foreach ($selected_deps as $departmentID){
                    $query = "INSERT INTO assUserDepartment (user_id, department_id)
                    SELECT :userID, :departmentID
                    WHERE NOT EXISTS (
                        SELECT 1
                        FROM assUserDepartment
                        WHERE user_id = :userID
                        AND department_id = :departmentID
                    )";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':userID', $idUser);
                    $statement->bindValue(':departmentID', $departmentID);
                    $result = $statement->execute();
                }
            }


            $stmt = $db->prepare("UPDATE User SET type = :type WHERE idUser = :id");
            $stmt->execute([
                'type' => $user_type,
                'id' => $idUser,
            ]);
            


            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit();
    }
}
    ob_end_flush();


?>