<?php
    declare(strict_types=1);

    class TicketChange {
        private int $idChange;
        private int $idTicket;
        private string $changedField;
        private string $oldValue;
        private string $newValue;
        private string $changeDate;
    
        public function __construct(int $idChange, int $idTicket, string $changedField, string $oldValue, string $newValue, string $changeDate) {
            $this->idChange = $idChange;
            $this->idTicket = $idTicket;
            $this->changedField = $changedField;
            $this->oldValue = $oldValue;
            $this->newValue = $newValue;
            $this->changeDate = $changeDate;
        }

        
        public static function getTicketChanges(PDO $db, int $idTicket){
            $stmt = $db->prepare('SELECT idChange, idTicket, ChangedField, OldValue, NewValue, ChangeDate FROM TicketChange WHERE idTicket = ?');
            $stmt->execute(array($idTicket));
            $ticketChanges = array();

            while($ticketChange = $stmt->fetch()){
                $ticketChanges[] = new TicketChange(
                    $ticketChange['idChange'],
                    $ticketChange['idTicket'],
                    $ticketChange['ChangedField'],
                    $ticketChange['OldValue'],
                    $ticketChange['NewValue'],
                    $ticketChange['ChangeDate']
                );
            }
    
            return $ticketChanges;
        }

        public function getIdChange(): int {
            return $this->idChange;
        }
    
        public function getIdTicket(): int {
            return $this->idTicket;
        }
    
        public function getChangedField(): string {
            return $this->changedField;
        }
    
        public function getOldValue(): string {
            return $this->oldValue;
        }
    
        public function getNewValue(): string {
            return $this->newValue;
        }
    
        public function getChangeDate(): string {
            return $this->changeDate;
        }
    }
    

?>