<?php

    declare(strict_types=1);
    
    class Department{

        private int $id;
        private string $title;
        private string $description;

        public function __construct(int $id, string $title, string $description){
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
        }

        static public function getDepartment(PDO $db, int $id){
            $stmt = $db->prepare('SELECT idDepartment, Title, Description FROM Department where idDepartment = ?');
            $stmt->execute(array($id));
            $department = $stmt->fetch();

            return new Department(
                $department['idDepartment'],
                $department['Title'],
                $department['Description'],
            );
        }


        public static function getUserDepartments(PDO $db, int $id) : ?array{

            $stmt = $db->prepare('SELECT user_id, department_id FROM assUserDepartment WHERE user_id = ?');
            $stmt->execute(array($id));
            $departments = array();

            while($association = $stmt->fetch()){
                $departments[] =  self::getDepartment($db, $association['department_id']);
            }
            return $departments;
        }

        public static function getDepartments(PDO $db) : ?array{
            $stmt = $db->prepare('SELECT idDepartment, Title, Description FROM Department');
            $stmt->execute(array());
            $departments = array();

            while($department = $stmt->fetch()){
                $departments[] = new Department(
                    $department['idDepartment'],
                    $department['Title'],
                    $department['Description'],
                );
            }
            return $departments;
        }

        public function getId() {
            return $this->id;
        }
        public function getDescription() {
            return $this->description;
        }
        public function getTitle() {
            return $this->title;
        }


    }

?>