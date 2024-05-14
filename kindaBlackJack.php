<?php

$suits = ['hearts', 'spades', 'diamonds', 'clubs'];
$values = ['2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, 'Jack' => 10, 'Queen' => 10, 'King' => 10, 'Ace' => 0];

function aceValue () {
    $values = [1, 11];
    $rnd_num = rand(0, 1);

    return $values[$rnd_num];
}

$card_deck = [];

foreach($suits as $suit) {
    foreach($values as $value => $points) {

        if($value == 'Ace') {
            $points = aceValue();
            $card_deck["$value of $suit"] = $points;
            
        } else {
            $card_deck["$value of $suit"] = $points;
        }
    }
};

$card_deck_keys = array_keys($card_deck);


function getRandomCard(&$deck, &$deck_keys) {
    shuffle($deck_keys);
    $card_key = array_pop($deck_keys);
    return $deck[$card_key];
}

function dealCards(&$deck, &$deck_keys) {
    return[getRandomCard($deck, $deck_keys),getRandomCard($deck, $deck_keys)];
}

function calculatePoints($cards) {
    $player_points = array_sum($cards);

    return $player_points;
}

function whoWonRound ($points_player1, $points_player2) {
    if ($points_player1 === $points_player2) {
        return "Draw";
    } elseif($points_player1 === 21) {
        return "Blackjack P1";
    } elseif($points_player2 === 21) {
        return "Blackjack P2";
    } elseif($points_player1 > $points_player2){
        return "Player1";
    } elseif ($points_player1 < $points_player2) {
        return "Player2";
    }
}


function playRound($deck, $deck_keys) {
    $player1_cards = dealCards($deck, $deck_keys);
    $player2_cards = dealCards($deck, $deck_keys);

    $player1_points = calculatePoints($player1_cards);
    $player2_points = calculatePoints($player2_cards);

    return whoWonRound($player1_points, $player2_points);
}

function game($deck, $deck_keys) {
    $rounds_played = 0;
    $rounds_won_p1 = 0;
    $rounds_won_p2 = 0;

    while($rounds_played < 5) {
        $round_result = playRound($deck, $deck_keys);

        if($round_result === 'Player1') {
            $rounds_won_p1++;
            echo "P1 $rounds_won_p1 : $rounds_won_p2 P2";
            echo "<br>";
        }

        if($round_result === 'Player2') {
            $rounds_won_p2++;
            echo "P1 $rounds_won_p1 : $rounds_won_p2 P2";
            echo "<br>";
        }

        if($round_result === 'Draw') {
            echo "P1 $rounds_won_p1 : $rounds_won_p2 P2 || Draw";
            echo "<br>";
        }

        if($round_result === 'Blackjack P1') {
            echo "P1 has a Blackjack and won the game.";
            break;
        }

        if($round_result === 'Blackjack P2') {
            echo "P1 has a Blackjack and won the game.";
            break;
        }

        $rounds_played++;
    }


    if($rounds_played === 5 && $rounds_won_p1 > $rounds_won_p2) {
        echo "Spieler 1 hat mit $rounds_won_p1 : $rounds_won_p2 gewonnen";
    } elseif($rounds_played === 5 && $rounds_won_p1 < $rounds_won_p2) {
        echo "Spieler 2 hat mit $rounds_won_p2 : $rounds_won_p1 gewonnen";
    } elseif($rounds_played === 5 && $rounds_won_p1 === $rounds_won_p2) {
        echo "Spieler 2 hat mit $rounds_won_p2 : $rounds_won_p1 gewonnen";
    }
}

game($card_deck, $card_deck_keys);