<?php
declare(strict_types=1);

class Task{

    private int $id;
    private string $description;
    private string $status;
    private int $idTicket;
    private string $nameAgent;

    public function __construct(int $id, string $description, string $status, int $idTicket, string $nameAgent){
        $this->id = $id;
        $this->description = $description;
        $this->status = $status;
        $this->idTicket = $idTicket;
        $this->nameAgent = $nameAgent;
    }

    public static function getTicketTasks(PDO $db, int $idTicket){

        $stmt = $db->prepare('SELECT idTask, Description, Status, idAgent FROM Task where idTicket = ?');
        $stmt->execute(array($idTicket));
        $tasks = array();

        while($task = $stmt->fetch()){
            $agentName = User::getUser($db, $task['idAgent'])->getName();
            $tasks[] = new Task(
                $task['idTask'],
                $task['Description'],
                $task['Status'],
                $idTicket,
                $agentName
            );
        }

        return $tasks;
    }

    public static function getTask(PDO $db, int $idTask){
        $stmt = $db->prepare('SELECT idTask, Description, Status, idAgent, idTicket  FROM Task where idTask = ?');
        $stmt->execute(array($idTask));
        $task = $stmt->fetch();

        return new Task(
                $task['idTask'],
                $task['Description'],
                $task['Status'],
                $task['idTicket'],
                $agentName = User::getUser($db, $task['idAgent'])->getName(),
            );
    }

    public function getId() {
        return $this->id;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getStatus() {
        return $this->status;
    }
    public function getTicketId() {
        return $this->idTicket;
    }
    public function getAgentName(){
        return $this->nameAgent;
    }


}




?>