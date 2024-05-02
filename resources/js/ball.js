const INITIAL_VELOCITY = .055
const VELOCITY_INCREASE = 0.0001

export default class Ball {
    constructor(ballElem) {
        this.ballElem = ballElem;
        this.reset()
    }

    // get ball data
    get x() {
        return parseFloat(getComputedStyle(this.ballElem).getPropertyValue("--x"))
    }
    get y() {
        return parseFloat(getComputedStyle(this.ballElem).getPropertyValue("--y"))
    }


    // set data ball
    set x(value) {
        this.ballElem.style.setProperty("--x", value)
    }
    set y(value) {
        this.ballElem.style.setProperty("--y", value)
    }

    rect() {
        return this.ballElem.getBoundingClientRect()
    }

    // helper function
    reset() {
        this.x = 50
        this.y = 50
        // velocity calculate
        this.direction = { x: 0 }

        while (Math.abs(this.direction.x) <= 0.2 || Math.abs(this.direction.x) >= 0.9) {
            const heading = randomNumberBetween(0, 2 * Math.PI)
            this.direction = { x: Math.cos(heading), y: Math.sin(heading) }

        }

        this.velocity = INITIAL_VELOCITY
        // console.log(this.direction)
    }

    update(delta, paddleRects) {
        this.x += this.direction.x * this.velocity * delta
        this.y += this.direction.y * this.velocity * delta

        // update background color
        const hue = parseFloat(getComputedStyle(document.documentElement).getPropertyValue("--hue"))
        

        const rect = this.rect()

        // check bounding box
        if (rect.bottom >= window.innerHeight || rect.top <= 0) {
            // speed up
            this.velocity += VELOCITY_INCREASE * delta
            document.documentElement.style.setProperty("--hue", hue + delta * 0.01)
            this.direction.y *= -1
        }

        // bouce of the paddle
        if (paddleRects.some(r => isCollision(r, rect))) {
            // speed up
            this.velocity += VELOCITY_INCREASE * delta
            document.documentElement.style.setProperty("--hue", hue + delta * 0.01)
            this.direction.x *= -1
        }
        // if (rect.right >= window.innerWidth || rect.left <= 0) {
        //     this.direction.x *= -1
        // }
    }
}

function randomNumberBetween(min, max) {
    return Math.random() * (max - min) + min
}

function isCollision(rect1, rect2) {
    return (rect1.left <= rect2.right && rect1.right >= rect2.left && rect1.top <= rect2.bottom && rect1.bottom >= rect2.top)
}
