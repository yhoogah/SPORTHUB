<?php

class SnakeGame {
    private $width = 20;
    private $height = 20;
    private $snake = [[10, 10]];
    private $food = [15, 15];
    private $direction = 'right';
    private $score = 0;

    public function __construct() {
        $this->initGame();
    }

    private function initGame() {
        system('clear'); // clear the terminal screen
        echo "Welcome to Snake Game!\n";
        echo "Use 'w', 'a', 's', 'd' to move the snake.\n";
        echo "Press 'q' to quit.\n";
        $this->drawGameBoard();
    }

    private function drawGameBoard() {
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                if ($x == $this->food[0] && $y == $this->food[1]) {
                    echo '*'; // food
                } elseif (in_array([$x, $y], $this->snake)) {
                    echo 'S'; // snake body
                } else {
                    echo ' '; // empty space
                }
            }
            echo "\n";
        }
        echo "Score: $this->score\n";
    }

    private function moveSnake() {
        $newHead = $this->snake[0];
        switch ($this->direction) {
            case 'up':
                $newHead[1]--;
                break;
            case 'down':
                $newHead[1]++;
                break;
            case 'left':
                $newHead[0]--;
                break;
            case 'right':
                $newHead[0]++;
                break;
        }

        if ($newHead[0] < 0 || $newHead[0] >= $this->width || $newHead[1] < 0 || $newHead[1] >= $this->height) {
            $this->gameOver();
        } elseif (in_array($newHead, $this->snake)) {
            $this->gameOver();
        } elseif ($newHead[0] == $this->food[0] && $newHead[1] == $this->food[1]) {
            $this->score++;
            $this->snake[] = $newHead;
            $this->generateFood();
        } else {
            $this->snake[] = $newHead;
            array_shift($this->snake);
        }
    }

    private function generateFood() {
        $this->food = [rand(0, $this->width - 1), rand(0, $this->height - 1)];
        while (in_array($this->food, $this->snake)) {
            $this->food = [rand(0, $this->width - 1), rand(0, $this->height - 1)];
        }
    }

    private function gameOver() {
        system('clear');
        echo "Game Over! Your score is $this->score\n";
        exit;
    }

    public function play() {
        while (true) {
            $input = trim(fgets(STDIN));
            switch ($input) {
                case 'w':
                    $this->direction = 'up';
                    break;
                case 'a':
                    $this->direction = 'left';
                    break;
                case 's':
                    $this->direction = 'down';
                    break;
                case 'd':
                    $this->direction = 'right';
                    break;
                case 'q':
                    exit;
            }
            $this->moveSnake();
            $this->drawGameBoard();
            usleep(100000); // slow down the game
        }
    }
}

$game = new SnakeGame();
$game->play();

?>