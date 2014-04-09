<?php

namespace LoveSay;

class NoteRepository
{

    /**
     * @return Note
     */
    public function getRandomNote()
    {
        $say = array();
        array_push($say, "You smile at me when I come home");
        array_push($say, "You think steam punk is cool");
        array_push($say, "You make awesome clothes for all of us");
        array_push($say, "You support our family");
        array_push($say, "You like spy movies");
        array_push($say, "You make people’s ideas and dreams become real");
        array_push($say, "You want me to do what will make me happy");
        array_push($say, "You can make a fantastic dinner from virtually bare cupboards");
        array_push($say, "You have grit – like 60 grit, not that lightweight 220 stuff");
        array_push($say, "You’ll stay up late playing video games with me");
        array_push($say, "You are the person I want to be with");
        shuffle($say);

        $note = new Note($say[0]);

        return $note;
    }

    public function addNote(Note $note)
    {
        return true;
    }

}
