// import
import Ball from "../js/ball.js";
import Paddle from "../js/paddle.js";

// initialize
const ball = new Ball(document.getElementById('ball'))
const playerPaddle = new Paddle(document.getElementById('player-paddle'))
const computerPaddle = new Paddle(document.getElementById('computer-paddle'))

const playerScore = document.getElementById('player-score')
const computerScore = document.getElementById('computer-score')

// Update loop
let lastTime
function update(time) {
    // convert to delta
    // var lastTime = 0
    if (lastTime != null) {
        const delta = time - lastTime

        // update code

        // move the ball
        ball.update(delta, [playerPaddle.rect(), computerPaddle.rect()])

        // update computer paddle
        computerPaddle.update(delta, ball.y)

        // update if the ball have come past the side
        if (isLose()) handleLose()

        // console.log(delta)
    }

    lastTime = time
    window.requestAnimationFrame(update)

    // console.log(time)
}

// check if lost
function isLose() {
    // check if outside bounds
    const rect = ball.rect()
    return rect.right >= window.innerWidth || rect.left <= 0
}

function handleLose() {
    // add the score
    const rect = ball.rect()
    // add score to player
    if (rect.right >= window.innerHeight) {
        playerScore.textContent = parseInt(playerScore.textContent) + 1
    }else {
        // add score to computer if won
        computerScore.textContent = parseInt(computerScore.textContent) + 1
    }

    // reset the game
    ball.reset()
    computerPaddle.reset()
}

// input of the mouse y position for the player paddle
document.addEventListener("mousemove", e => {
    // converted to 0 to 100
    playerPaddle.position = (e.y / window.innerHeight) * 100
})

// calls an infinite loop
window.requestAnimationFrame(update)