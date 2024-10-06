<?php
    declare(strict_types = 1);
    require_once('department.class.php');

    class User
    {
        private ?int $id;
        private string $name;
        private string $email;
        private string $password;
        private string $type;
        private ?array $departments;

        public function __construct(string $name, string $email, string $password, string $type, ?int $id, ?array $departments)
        {
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->type = $type;
            $this->id = $id;
            $this->departments = $departments;
        }
        static public function getUser(PDO $db, ?int $id) {
            if ($id === -1) {
                return new User('Default User', '', '', '', null, null);
            }

            $stmt = $db->prepare('SELECT idUser, Name, Email, Password, type FROM User WHERE idUser = ?');
            $stmt->execute(array($id));

            $user = $stmt->fetch();
            return new User(
                $user['Name'],
                $user['Email'],
                $user['Password'],
                $user['type'],
                $user['idUser'],
                Department::getUserDepartments($db, $id),
            );
        }

        static function getUserWithPassword(PDO $db, string $email, string $password): ?User
        {
            $stmt = $db->prepare('
                SELECT idUser, Name, Email, Password, type
                FROM User
                WHERE Email = ?
            ');
        
            $stmt->execute(array($email));
            $customer = $stmt->fetch();
        
            if ($customer) {
                $hashedPassword = $customer['Password'];
                //A segunda condition e para retirar antes da entrega do trabalho, ta a aceitar ler passwords sem estarem hashed so para o debug naqueles casos testes
                if (password_verify($password, $hashedPassword) || $password === $hashedPassword) {
                    return new User(
                        $customer['Name'],
                        $customer['Email'],
                        $customer['Password'],
                        $customer['type'],
                        $customer['idUser'],
                        Department::getUserDepartments($db, $customer['idUser'])
                    );
                }
            }
        
            return null;
        }
        

        static function getAgents(PDO $db) :?array {
            $stmt = $db->prepare('SELECT idUser, Name, Email, Password, type FROM User WHERE type = "Agent"');    
            $stmt->execute(array());
            $agents = array();
        
            while($agent = $stmt->fetch()){
                $agents[] = new User(
                    $agent['Name'],
                    $agent['Email'],
                    $agent['Password'],
                    $agent['type'],
                    $agent['idUser'],
                    Department::getUserDepartments($db, $agent['idUser']),
                );
            }
            return $agents;
        }

        static function getUsers(PDO $db) : ?array{
            $stmt = $db->prepare('Select idUser, Name, Email, Password, type FROM User');
            $stmt->execute(array());
            $users = array();

            while($user = $stmt->fetch()){
                $users[] = new User(
                    $user['Name'],
                    $user['Email'],
                    $user['Password'],
                    $user['type'],
                    $user['idUser'],
                    Department::getUserDepartments($db, $user['idUser']),
                );
            }

            
            return $users;
        }

        public function getId() {
            return $this->id;
        }
        public function getName() {
            return $this->name;
        }

        public function getEmail() {
            return $this->email;
        }
        public function getPassword() {
            return $this->password;
        }
        public function getType() {
            return $this->type;
        }
        public function getDepartments() {
            return $this->departments;
        }
}
?>