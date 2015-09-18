/* This will be a very simple canvas example. We will cover very very basic functions of the context

I'm not going to include shims or anything, I'll cover that later.

First off, let's get all the non-canvas things out of the way.

Let's set up a simple world model. This will be a simple bouncing ball example, with no gravity, friction, or collisions between balls*/

//World Constructor Function
//Width and height are px in this case
function World(width, height) {
  //save our custom size or use default value
  this.width = width || window.innerWidth;
  this.height = height || window.innerHeight;
  
  this.balls = [];
  
  //private constructor function, pixel xy and radius of circle
  function Ball(x, y, rad) {
    //save or use default
    this.x = x || 0;
    this.y = y || 0;
    this.rad = rad || 25;
    
    //Establish velocity, randomly -5 through 5
    this.velX = Math.random()*5 - Math.random()*5;
    this.velY = Math.random()*5 - Math.random()*5;
    
    //assign random color
    this.color = '#'+Math.floor(Math.random()*16777215).toString(16);
  }
  
  //fill the balls array, using the private constructor
  while(this.balls.length < 5) {
    this.balls.push(new Ball(
      Math.random()*this.width, //x
      Math.random()*this.height, //y
      Math.random()*35+5 //radius, with min of 5 & max of 40
    ));
  }
  
  //world tick function
  //if you had more than one entity type, i.e. balls & cubes, you'd want to have update functions in each entity's constructor, and not here. This is just simple enough to work.
  //also you will usually want to account for time between frames when applying velocity
  this.update = function() {
    //iterate over each ball
    for(var b in this.balls) {
      //shortcut variable
      var ball = this.balls[b];
      
      //reverse velocity when out of bounds
      if(ball.x < 0 || ball.x > width ) {        
        ball.velX = -ball.velX;
      }
      if(ball.y < 0 || ball.y > height) {
        ball.velY = -ball.velY;
      }
      
      //apply velocity
      ball.x += ball.velX;
      ball.y += ball.velY;
    }
  };
}

/*There, a simple ball bounce world constructor. 

Now we need to set up the canvas, and the animation loop

Canvas is the drawing surface, and context is sort of the tool box and reference*/

//create a new world using the constructor, and prepare the canvas and drawing context
var world = new World(),
    canvas = document.body.appendChild(document.createElement("canvas")),
    ctx = canvas.getContext("2d");

/* you could also do:
 * canvas = document.getElementById("prexistingCanvasID");
 * instead of creating a new one */

//Size the canvas to the world
canvas.width = world.width;
canvas.height = world.height;

//Now we can finally get down how to draw things using canvas!
function draw() {
  //set the "fill" color
  ctx.fillStyle = "#FFF";
  
  //now clear the frame
  /* you can also use ctx.clearRect() with the same parameters
   * if you want a transparent background */
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  
  //iterate each ball
  for(var b in world.balls) {
    //shortcut
    var ball = world.balls[b];
    
    //set fill color to the balls random color
    ctx.fillStyle = ball.color;
    
    //begin a new "line"
    ctx.beginPath();
    
    //create the circle (see http://www.w3schools.com/tags/canvas_arc.asp)
    ctx.arc(
      ball.x, //center x
      ball.y, //center y
      ball.rad, //radius of circle
      0, //arc start - 3 o'clock
      2*Math.PI //arc end - 100%
    );
    
    //fill the path we just created, and close it
    ctx.fill();
  }
}

//This is our animation loop
/*by using requestAnimationFrame, it will be called over and over as quickly as possible 

this is where you'd normally want a shim/polyfill, so requestAnimationFrame works on as many browsers as it can

see http://www.paulirish.com/2011/requestanimationframe-for-smart-animating/*/
function animate() {
  //update the world
  world.update();
  
  //draw the world
  draw();
  
  //set up the next frame
  requestAnimationFrame(animate);
}

animate();