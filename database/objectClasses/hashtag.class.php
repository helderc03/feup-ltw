<?php
declare(strict_types=1);

class Hashtag{
    private int $id;
    private string $title;
    private int $idDepartment;


    public function __construct(int $id, string $title, int $idDepartment){
        $this->id = $id;
        $this->title = $title;
        $this->idDepartment = $idDepartment;
    }

    public static function getHashtag(PDO $db, int $id){
        $stmt = $db->prepare('SELECT idHashtag, Title, idDepartment from Hashtag where idHashtag  = ?');
        $stmt->execute(array($id));
        $hashtag = $stmt->fetch();

        return new Hashtag(
            $hashtag['idHashtag'],
            $hashtag['Title'],
            $hashtag['idDepartment']
        );
    }

    public static function getAllHashtags(PDO $db){
        $stmt = $db->prepare('SELECT idHashtag, Title, idDepartment from Hashtag');
        $stmt->execute(array());
        $hashtags = array();

        while($hashtag = $stmt->fetch()){
            $hashtags[] = new Hashtag(
                $hashtag['idHashtag'],
                $hashtag['Title'],
                $hashtag['idDepartment']
            );
        }
        return $hashtags;
    }
    
    public static function getTicketHashtags(PDO $db, int $id) : array{
        $stmt = $db->prepare('SELECT ticket_id, hashtag_id  from assTicketHashtag where ticket_id = ?');
        $stmt->execute(array($id));
        $hashtags = array();

        //tenho de passar o id da hashtag
        while($association = $stmt->fetch()){
            $hashtags[] =  self::getHashtag($db, $association['hashtag_id']);
        }
        return $hashtags;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getIdDepartment() {
        return $this->idDepartment;
    }

}

?>