<?php
declare(strict_types=1);

class Ticket{
    private int $id;
    private string $title;
    private string $status;
    private string $priority;
    private string $description;
    private int $idAgent;
    private int $idClient;
    private int $idDepartment;
    private ?int $similarTicket;

    public function __construct(int $id, string $title, string $status, string $priority, string $description, int $idClient, int $idDepartment, ?int $idAgent = null, ?int $similarTicket){
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
        $this->priority = $priority;
        $this->description = $description;
        $this->idClient = $idClient;
        $this->idDepartment = $idDepartment;
        $this->idAgent = $idAgent;
        $this->similarTicket = $similarTicket;
    }

    public static function getTicket(PDO $db, int $id){
        $stmt = $db->prepare('SELECT idTicket, Title, Status, Priority, Description, idClient, idDepartment, idAgent, similarTicket FROM Ticket WHERE idTicket = ?');
        $stmt->execute(array($id));
        $ticket = $stmt->fetch();
        
        return new Ticket(
            $ticket['idTicket'],
            $ticket['Title'],
            $ticket['Status'],
            $ticket['Priority'],
            $ticket['Description'],
            $ticket['idClient'],
            $ticket['idDepartment'],
            $ticket['idAgent'],
            $ticket['similarTicket']
        );
    }

    public static function getUserTickets(PDO $db, int $id, string $type_user) : ?array{

        if ($type_user == "Client") {
            $stmt = $db->prepare('SELECT * FROM Ticket where idClient = ?');
            $stmt->execute(array($id));
        } else if($type_user == "Agent"){
            $stmt = $db->prepare('SELECT * FROM Ticket where idAgent = ?');
            $stmt->execute(array($id));
        }
    
        $tickets = array();

        while($ticket = $stmt->fetch()){
            $tickets[] = new Ticket(
                $ticket['idTicket'],
                $ticket['Title'],
                $ticket['Status'],
                $ticket['Priority'],
                $ticket['Description'],
                $ticket['idClient'],
                $ticket['idDepartment'],
                $ticket['idAgent'],
                $ticket['similarTicket'],
            );
        }

        return $tickets;
    }

    public static function getUnassignedTickets(PDO $db) : ?array{
        $stmt = $db->prepare('SELECT idTicket, Title, Status, Priority, Description, idClient, idDepartment, idAgent FROM Ticket where idAgent = -1');
        $stmt->execute(array());
        $tickets = array();
        
        while($ticket = $stmt->fetch()){
            $tickets[] = new Ticket(
                $ticket['idTicket'],
                $ticket['Title'],
                $ticket['Status'],
                $ticket['Priority'],
                $ticket['Description'],
                $ticket['idClient'],
                $ticket['idDepartment'],
                $ticket['idAgent'],
                $ticket['similarTicket'],
            );
        }

        return $tickets;
    }

    public static function getAllTickets(PDO $db) : ?array{
        $stmt = $db->prepare('SELECT idTicket, Title, Status, Priority, Description, idClient, idDepartment, idAgent, similarTicket FROM Ticket');
        $stmt->execute(array());
        $tickets = array();
        
        while($ticket = $stmt->fetch()){
            $tickets[] = new Ticket(
                $ticket['idTicket'],
                $ticket['Title'],
                $ticket['Status'],
                $ticket['Priority'],
                $ticket['Description'],
                $ticket['idClient'],
                $ticket['idDepartment'],
                $ticket['idAgent'],
                $ticket['similarTicket'],
            );
        }

        return $tickets;
    }

    public static function getOpenTickets(PDO $db) : ?array{
        $stmt = $db->prepare("SELECT idTicket, Title, Status, Priority, Description, idClient, idDepartment, idAgent, similarTicket FROM Ticket WHERE Status='Open'");
        $stmt->execute(array());
        $tickets = array();
        while($ticket = $stmt->fetch()){
            $tickets[] = new Ticket(
                $ticket['idTicket'],
                $ticket['Title'],
                $ticket['Status'],
                $ticket['Priority'],
                $ticket['Description'],
                $ticket['idClient'],
                $ticket['idDepartment'],
                $ticket['idAgent'],
                $ticket['similarTicket'],
            );
        }

        return $tickets;

    }

    public static function getNumberTicketsOpenedByClient(PDO $db, int $id){
        $stmt = $db->prepare("SELECT COUNT(*) AS numTickets FROM Ticket WHERE idClient = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $numTickets = $result['numTickets'];
    
        return $numTickets;
    }

    public static function getNumberTicketsClosedByAgent(PDO $db, int $id){
        $stmt = $db->prepare("SELECT COUNT(*) as numTickets FROM Ticket WHERE idAgent = :id AND Status = 'Closed'");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $numTickets = $result['numTickets'];
        return $numTickets;
    }



    public function getId() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getStatus() {
        return $this->status;
    }
    public function getPriority() {
        return $this->priority;
    }
    public function getDescription() {
        return $this->description;
    }

    public function getIdClient() {
        return $this->idClient;
    }

    public function getIdAgent() {
        return $this->idAgent;
    }

    public function getIdDepartment() {
        return $this->idDepartment;
    }

    public function getSimilarTicket(){
        return $this->similarTicket;
    }

}


?>