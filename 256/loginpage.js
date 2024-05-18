let W = window.innerWidth;
let H = window.innerHeight;
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const maxConfettis = 150;
const particles = [];

// Font Awesome icons
const icons = ["\uf094", "\uf578", "\uf72f", "\uf818", "\uf816", "\uf810", "\uf563", "\uf7ef", "\uf787", "\uf5d1", "\uf7ec"]; // Add more Font Awesome Unicode values

// Limited color palette for food theme
const colors = [
  "#FF6347", // Tomato
  "#FFD700", // Gold
  "#ADFF2F", // GreenYellow
  "#FF4500", // OrangeRed
  "#FFA07A", // LightSalmon
  "#CD5C5C", // IndianRed
  "#DAA520", // GoldenRod
  "#BDB76B"  // DarkKhaki
];

function randomFromTo(from, to) {
  return Math.floor(Math.random() * (to - from + 1) + from);
}

function confettiParticle() {
  this.x = Math.random() * W; // x
  this.y = Math.random() * H - H; // y
  this.r = randomFromTo(11, 33); // radius (used for font size)
  this.d = Math.random() * maxConfettis + 11;
  this.icon = icons[Math.floor(Math.random() * icons.length)]; // Random icon
  this.color = colors[Math.floor(Math.random() * colors.length)]; // Random color from palette
  this.tilt = Math.floor(Math.random() * 33) - 11;
  this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
  this.tiltAngle = 0;

  this.draw = function() {
    context.save();
    context.font = `${this.r}px FontAwesome`;
    context.fillStyle = this.color;
    context.translate(this.x, this.y);
    context.rotate(this.tiltAngle);
    context.fillText(this.icon, -this.r / 2, this.r / 2);
    context.restore();
  };
}

function Draw() {
  const results = [];

  // Magical recursive functional love
  requestAnimationFrame(Draw);

  context.clearRect(0, 0, W, window.innerHeight);

  for (let i = 0; i < maxConfettis; i++) {
    results.push(particles[i].draw());
  }

  let particle = {};
  let remainingFlakes = 0;
  for (let i = 0; i < maxConfettis; i++) {
    particle = particles[i];

    particle.tiltAngle += particle.tiltAngleIncremental * 0.5; // Reduce tilt speed
    particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) * 0.1; // Reduce fall speed
    particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

    if (particle.y <= H) remainingFlakes++;

    // If a confetti has fluttered out of view,
    // bring it back to above the viewport and let it re-fall.
    if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
      particle.x = Math.random() * W;
      particle.y = -30;
      particle.tilt = Math.floor(Math.random() * 10) - 20;
    }
  }

  return results;
}

function initConfetti() {
  window.addEventListener(
    "resize",
    function() {
      W = window.innerWidth;
      H = window.innerHeight;
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    },
    false
  );

  // Push new confetti objects to `particles[]`
  for (let i = 0; i < maxConfettis; i++) {
    particles.push(new confettiParticle());
  }

  // Initialize
  canvas.width = W;
  canvas.height = H;
  Draw();
}

// Call initConfetti when the DOM content is fully loaded
document.addEventListener("DOMContentLoaded", function() {
  initConfetti();
});
