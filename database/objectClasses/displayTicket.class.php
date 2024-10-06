<?php
    declare(strict_types=1);
    require_once('user.class.php');
    require_once('ticket.class.php');
    require_once('hashtag.class.php');
    require_once('department.class.php');


    
    class displayTicket{
        private int $id;
        private string $title;
        private string $description;
        private string $priority;
        private string $status;
        private string $clientName;
        private string $agentName;
        private array $hashtags;
        private string $departmentName;
        private ?int $similarTicket;

        public function __construct(int $id, string $title, string $description, string $priority, string $status, string $clientName, string $agentName, array $hashtags, string $departmentName, ?int $similarTicket){
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->priority = $priority;
            $this->status = $status;
            $this->clientName = $clientName;
            $this->agentName = $agentName;
            $this->hashtags = $hashtags;
            $this->departmentName = $departmentName;
            $this->similarTicket = $similarTicket;
        }

        static public function getDisplayTickets(PDO $db, int $id, string $type_user) : ?array{
            $tickets = Ticket::getUserTickets($db, $id, $type_user);

            if ($tickets === null || count($tickets) === 0) {
                return null;
            }else{
                foreach ($tickets as $ticket) {
                    $clientName = User::getUser($db, $ticket->getIdClient())->getName();
                    $agentName = User::getUser($db, $ticket->getIdAgent())->getName();
                    $departmentName = Department::getDepartment($db, $ticket->getIdDepartment())->getTitle() ;
                    
                    $ticketsDisplay[] = new displayTicket(
                        $ticket->getId(),
                        $ticket->getTitle(),
                        $ticket->getDescription(),
                        $ticket->getPriority(),
                        $ticket->getStatus(),
                        $clientName,
                        $agentName,
                        Hashtag::getTicketHashtags($db, $ticket->getId()),
                        $departmentName,
                        $ticket->getSimilarTicket(),
                    );
                }
            }

            return $ticketsDisplay;
        }

        static public function getDisplayTicket(PDO $db, int $id){
            $ticket = Ticket::getTicket($db, $id);
            $clientName = User::getUser($db, $ticket->getIdClient())->getName();
            $agentName = User::getUser($db, $ticket->getIdAgent())->getName();
            $departmentName = Department::getDepartment($db, $ticket->getIdDepartment())->getTitle() ;

            return new displayTicket( 
                $ticket->getId(),
                $ticket->getTitle(),
                $ticket->getDescription(),
                $ticket->getPriority(),
                $ticket->getStatus(),
                $clientName,
                $agentName,
                Hashtag::getTicketHashtags($db, $ticket->getId()),
                $departmentName,
                $ticket->getSimilarTicket(),

            );
    
        }

        static public function getDisplayUnassignedTickets(PDO $db): ?array{
            $tickets = Ticket::getUnassignedTickets($db);

            if ($tickets === null || count($tickets) === 0) {
                return null;
            }else{
                foreach ($tickets as $ticket) {
                    $clientName = User::getUser($db, $ticket->getIdClient())->getName();
                    $agentName = User::getUser($db, $ticket->getIdAgent())->getName();
                    $departmentName = Department::getDepartment($db, $ticket->getIdDepartment())->getTitle() ;

                    $ticketsDisplay[] = new displayTicket(
                        $ticket->getId(),
                        $ticket->getTitle(),
                        $ticket->getDescription(),
                        $ticket->getPriority(),
                        $ticket->getStatus(),
                        $clientName,
                        $agentName,
                        Hashtag::getTicketHashtags($db, $ticket->getId()),
                        $departmentName,
                        $ticket->getSimilarTicket(),

                    );
                }
            }

            return $ticketsDisplay;
        }

        static public function getAllDisplayTickets(PDO $db) : ?array{
            $tickets = Ticket::getAllTickets($db);
            if ($tickets === null || count($tickets) === 0) {
                return null;
            }else{
                foreach ($tickets as $ticket) {
                    $clientName = User::getUser($db, $ticket->getIdClient())->getName();
                    $agentName = User::getUser($db, $ticket->getIdAgent())->getName();
                    $departmentName = Department::getDepartment($db, $ticket->getIdDepartment())->getTitle() ;

                    $ticketsDisplay[] = new displayTicket(
                        $ticket->getId(),
                        $ticket->getTitle(),
                        $ticket->getDescription(),
                        $ticket->getPriority(),
                        $ticket->getStatus(),
                        $clientName,
                        $agentName,
                        Hashtag::getTicketHashtags($db, $ticket->getId()),
                        $departmentName,
                        $ticket->getSimilarTicket(),
                    );
                }
            }

            return $ticketsDisplay;
        }

        static public function getOpenTickets(PDO $db) : ?array{
            $tickets = Ticket::getOpenTickets($db);
            if ($tickets === null || count($tickets) === 0) {
                return null;
            }else{
                foreach ($tickets as $ticket) {
                    $clientName = User::getUser($db, $ticket->getIdClient())->getName();
                    $agentName = User::getUser($db, $ticket->getIdAgent())->getName();
                    $departmentName = Department::getDepartment($db, $ticket->getIdDepartment())->getTitle() ;

                    $ticketsDisplay[] = new displayTicket(
                        $ticket->getId(),
                        $ticket->getTitle(),
                        $ticket->getDescription(),
                        $ticket->getPriority(),
                        $ticket->getStatus(),
                        $clientName,
                        $agentName,
                        Hashtag::getTicketHashtags($db, $ticket->getId()),
                        $departmentName,
                        $ticket->getSimilarTicket(),
                    );
                }
            }

            return $ticketsDisplay;
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

        public function getClientName() {
            return $this->clientName;
        }

        public function getAgentName() {
            return $this->agentName;
        }

        public function getHashtags() {
            return $this->hashtags;
        }

        public function getDepartmentName() {
            return $this->departmentName;
        }

        public function getSimilarTicket(){
            return $this->similarTicket;
        }
    }



?>