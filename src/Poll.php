<?php
namespace Source\Action;

class Poll {

    static function getPlaceTraining (){
        $weekday= date('l');
        $week = date('W');
        switch ($weekday) {
            case 'Monday':
                $place = 'в Манеже';
                break;
            case 'Wednesday':
                $place = 'в Зале';
                break;
            case 'Friday':
                $place = 'в Манеже';
                break;
        }; // Monday ; Tuesday; Wednesday ; Thursday ; Friday ; Saturday ; Sunday
        return $place;
    }

    static function regExDatetoEmoji(){
        $_1 = "\x31\xE2\x83\xA3";
        $_2 = "\x32\xE2\x83\xA3";
        $_3 = "\x33\xE2\x83\xA3";
        $_4 = "\x34\xE2\x83\xA3";
        $_5 = "\x35\xE2\x83\xA3";
        $_6 = "\x36\xE2\x83\xA3";
        $_7 = "\x37\xE2\x83\xA3";
        $_8 = "\x38\xE2\x83\xA3";
        $_9 = "\x39\xE2\x83\xA3";
        $_0 = "\x30\xE2\x83\xA3";
        $string = date('d m Y');
        $pattern = '/([0-9])([0-9]) ([0-9])([0-9]) ([0-9])([0-9])([0-9])([0-9])/i';
        $replacement = '${_${1}}${_${2}} ${_${3}}${_${4}} ${_${5}}${_${6}}${_${7}}${_${8}}';
        $emojistring = preg_replace($pattern, $replacement, $string);
        eval("\$emojistring = \"$emojistring\";");
        return $emojistring;
    }

    static function getPollOption():string{
        $plus = "\xE2\x9E\x95";
        $minus = "\xE2\x9E\x96";
        $pill = "\xF0\x9F\x92\x8A";
        $yes = "Буду";
        $no = "Нет";
        $sick = "Болею";
        $options =  array("$yes $plus","$no $minus","$sick $pill") ;
        return json_encode($options);

    }
 

    static function getPollQuestion(){

        $time_t = "21:00";
        $rugby = "\xF0\x9F\x8F\x89";
        $time_clock = "\xE2\x8F\xB0";
        $plus = "\xE2\x9E\x95";
        $minus = "\xE2\x9E\x96";
        $pill = "\xF0\x9F\x92\x8A";
        $question = self::regExDatetoEmoji() . 
        "\n" . $rugby . " Тренировка " . 
        self::getPlaceTraining() . 
        "\n" . $time_clock . " "  . $time_t;
        return $question;
    }

    static function getJsonPoll($response){

        $update = json_decode($response, true);
        $poll_id = $update['result']['poll']['id'];
        $poll_message = $update['result']['message_id'];
        $chat_id = $update['result']['chat']['id'];
        return array(
            'poll_id' => $poll_id,
            'poll_message' => $poll_message,
            'chat_id ' => $chat_id
        );
    }

}

