<?php
    declare(strict_types=1);

    require_once('user.class.php');

    class Inquiry{

        private int $id;        
        private int $idTicket;
        private string $nameCreator;
        private string $description;
    
        public function __construct(int $id, int $idTicket, string $nameCreator, string $description){
            $this->id = $id;
            $this->idTicket = $idTicket;
            $this->nameCreator = $nameCreator;
            $this->description = $description;
        }
    
        public static function getTicketInquiries(PDO $db, int $idTicket){
            $stmt = $db->prepare('SELECT idInquiry, idTicket, idCreator, Description from Inquiry where idTicket  = ?');
            $stmt->execute(array($idTicket));
            $inquiries = array();

            while($inquiry = $stmt->fetch()){
                $inquiries[] = new Inquiry(
                    $inquiry['idInquiry'],
                    $inquiry['idTicket'],
                    User::getUser($db,$inquiry['idCreator'])->getName(),
                    $inquiry['Description'],
                );
            }
            return $inquiries;
        }

        
        public function getId() {
            return $this->id;
        }
        public function getIdTicket() {
            return $this->idTicket;
        }
        public function getNameCreator() {
            return $this->nameCreator;
        }
        public function getDescription() {
            return $this->description;
        }

    

    }
?>