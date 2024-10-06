<?php
declare(strict_types=1);
class Faq{
    private int $id;
    private string $question;
    private string $answer;

    public function __construct(int $id, string $question, string $answer){
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
    }

    static public function getFAQs(PDO $db){
        $stmt = $db->prepare('SELECT idFaq, Question, Answer FROM Faq');
        $stmt->execute();
        $faqs = array();

        while($faq = $stmt->fetch()){
            $faqs[] = new Faq(
                $faq['idFaq'],
                $faq['Question'],
                $faq['Answer']
            );
        }
        return $faqs;
    }

    public function getId() {
        return $this->id;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function getAnswer() {
        return $this->answer;
    }
}

?>