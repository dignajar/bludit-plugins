	canvas = document.getElementById("canvas");
	var context = canvas.getContext('2d');
	W = canvas.width = window.innerWidth;
	H = canvas.height = window.innerHeight;
	generatorStock=[];
//
// Add the Generator Here :)
//
generator1 = new particleGenerator(0, H+2,W, 0,30);

function loadImage(url) {
    var img = document.createElement("img");
    img.src = url;
    return img;
}

function drawTriangle(context, x, y, triangleWidth, triangleHeight, fillStyle){

context.save();
context.translate(0,-triangleHeight/2);

context.beginPath();<!--from   www. j a  v a  2s  .  c  o  m-->
context.moveTo(x, y);

context.lineTo(x + triangleWidth / 2, y + triangleHeight);
context.lineTo(x - triangleWidth / 2, y + triangleHeight);
context.restore();


context.closePath();
context.strokeStyle = fillStyle;
context.stroke();

}

function drawCircle(context, x, y, radius, fillStyle){
context.beginPath();
context.arc(x,y,radius,0,2*Math.PI);
context.closePath();
context.strokeStyle = fillStyle;
context.stroke();
}
function drawCross(context,fillStyle){
context.beginPath();
context.moveTo(0, 0);
context.lineTo(0, 10);

context.moveTo(-6, 5);
context.lineTo(6,5 );

context.closePath();
context.strokeStyle = fillStyle;
context.stroke();
}



	var mouse = {x: 0, y: 0};
	canvas.addEventListener('mousemove', function(e) {
		mouse.x = e.pageX - this.offsetLeft;
		mouse.y = e.pageY - this.offsetTop;
	}, false);
	
	function randomIntgf(min, max) {
		return Math.floor(min + Math.random() * (max - min + 1));
	}
	
	function randomInt(min, max) {
		return min + Math.random() * (max - min);
	}

		function clamp(value, min, max) {
		return Math.min(Math.max(value, Math.min(min, max)), Math.max(min, max));
	}
	function particle(x, y,type) {
	    this.radius = randomInt(.1, 3);
			    this.angleturn = randomInt(-.08, .08);
			    this.angle = randomInt(1,0);
	    this.type2 = randomIntgf(0,3);

	    this.x = x;
	    this.y = y;
	    this.vx =randomInt(-4, 4);
	    this.vy = randomInt(-2, 0);
		this.type=type;
	}
	particle.prototype.update = function() {
	    this.x += this.vx;
	    this.y += this.vy;
	    this.vy += -0.08;
	    this.vx *= 0.99;
	    this.vy *= 0.99;
		this.angle += this.angleturn;
	    this.radius -= .01;
	    context.beginPath();
		context.font = "30px arial";
		context.textAlign = "center";
	//	context.globalAlpha=1;
	    context.globalAlpha=this.radius;     
		
		context.lineWidth = 2;
      context.lineCap = 'round';

context.save();
context.translate(this.x,this.y);
context.rotate(this.angle);

if(this.type2 === 0){
	  drawTriangle(context,0,0,15,13,"#FC63B3");
}else if(this.type2 === 1){
	  drawCircle(context,0,0,8,"#FFF48D");

}else if(this.type2 === 2){
context.beginPath();
context.rect(0,0,13,13);
context.closePath();
context.strokeStyle = "#94FFF5";
context.stroke();
}else if(this.type2 === 3){
	  drawCross(context,"#D68FFF");

}
	  
	  
	  
context.restore();





	context.globalAlpha=1;
    if(this.y>H+5 ){
      this.vy *= -.5;
    }
        if(this.x>W|| this.x < 0){
      this.vx *= -1;
    }
	}

	function particleGenerator(x, y, w, h, number,text) {
	    // particle will spawn in this aera
	    this.x = x;
	    this.y = y;
	    this.w = w;
	    this.h = h;
	    this.number = number;
	    this.particles = [];
		this.text=text;
	}
	particleGenerator.prototype.animate = function() {
    
    

    
      context.fillStyle="grey";

	    context.beginPath();
	    context.strokeRect(this.x, this.y, this.w, this.h);

		context.font = "13px arial";
		context.textAlign = "center";

		
	    context.closePath();
		
		
		
	    if (this.particles.length < this.number) {
	        this.particles.push(new particle(clamp(randomInt(this.x, this.w+this.x),this.x,this.w+this.x), 
			
			clamp(randomInt(this.y,this.h+this.y),this.y,this.h+this.y),this.text));
	    }
	    for (var i = 0; i < this.particles.length; i++) {
	        p = this.particles[i];
	        p.update();
	        if (p.radius < .01 || p.y <0) {
	            //a brand new particle replacing the dead one
	            this.particles[i] = new particle(clamp(randomInt(this.x, this.w+this.x),this.x,this.w+this.x), 
			
			clamp(randomInt(this.y,this.h+this.y),this.y,this.h+this.y),this.text);
	        }
	    }
	}

	update();

	function update() {

  // context.globalAlpha=.5;
    context.clearRect(0,0,W,H);
    generator1.animate();
		
		
	    requestAnimationFrame(update);
	}