<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Red+Hat+Display:400,900&display=swap");
body {
  background: #301c5a;
  overflow: hidden;
  font-family: Red Hat Display, sans-serif;
  letter-spacing: 0.05rem;
  line-height: 1.5rem;
}

.stripe {
  position: absolute;
  height: 30rem;
  width: 400%;
  left: 50%;
  top: 50%;
  background: #FE5F55;
  transform: translate(-50%, -50%) rotate(-30deg);
}

.center {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.card {
  position: relative;
  background: #fff;
  color: #2C3534;
  width: 24rem;
  border-radius: 1rem;
  overflow: hidden;
  box-shadow: 0 0 8rem 0 rgba(0, 0, 0, 0.2), 0 2rem 4rem -3rem rgba(0, 0, 0, 0.9);
}
.card .dismiss {
  position: absolute;
  right: 1rem;
  top: 1rem;
  width: 2rem;
  height: 2rem;
  opacity: 0.6;
  cursor: pointer;
  z-index: 50;
  transition: opacity 200ms, transform 200ms cubic-bezier(0.25, 1, 0.5, 2);
}
.card .dismiss:before, .card .dismiss:after {
  content: "";
  position: absolute;
  left: 1rem;
  height: 1.5rem;
  width: 0.25rem;
  background: #2C3534;
  border-radius: 1rem;
  transform: rotate(45deg);
}
.card .dismiss:after {
  transform: rotate(-45deg);
}
.card .dismiss:hover {
  opacity: 0.8;
  transform: scale(1.1);
}
.card .illustration {
  position: relative;
  height: 10rem;
  background: #EDF9F8;
  overflow: hidden;
}
.card .content {
  padding: 2rem;
}
.card .content h2, .card .content p {
  opacity: 0.7;
  margin: 0;
}
.card .content h2 {
  opacity: 0.9;
  margin-bottom: 1rem;
}

.car {
  position: absolute;
  top: 7rem;
  left: 10rem;
  z-index: 30;
  -webkit-animation: car 10s infinite ease-in-out;
          animation: car 10s infinite ease-in-out;
}
.car .body {
  position: absolute;
  -webkit-animation: car-body 0.5s infinite;
          animation: car-body 0.5s infinite;
}
.car .body-front {
  content: "";
  position: absolute;
  left: 3rem;
  bottom: -2rem;
  height: 1rem;
  width: 1rem;
  background: white;
}
.car .body-front:after {
  content: "";
  position: absolute;
  bottom: 1rem;
  height: 0;
  width: 0;
  border-bottom: 1rem solid white;
  border-right: 1rem solid transparent;
}
.car .body-back {
  position: absolute;
  height: 2rem;
  width: 3rem;
  background: white;
  overflow: hidden;
}
.car .body-back:after {
  content: "";
  position: absolute;
  height: 0.5rem;
  width: 3rem;
  background: #FE5F55;
  transform: translate(-0.5rem, 0.2rem) rotate(-30deg);
}
.car .window {
  position: absolute;
  width: 0.4rem;
  height: 0.9rem;
  background: #8DA8A6;
  top: 0.1rem;
  left: 2.55rem;
}
.car .window:after {
  content: "";
  position: absolute;
  left: 0.4rem;
  height: 0;
  width: 0;
  border-bottom: 0.9rem solid #8DA8A6;
  border-right: 0.9rem solid transparent;
}
.car .wheel {
  position: absolute;
  top: 1.5rem;
  left: 0.25rem;
  height: 1rem;
  width: 1rem;
  border-radius: 50%;
  background: #333;
}
.car .wheel:after {
  content: "";
  position: absolute;
  height: 0.5rem;
  width: 0.5rem;
  left: 0.25rem;
  top: 0.25rem;
  border-radius: 50%;
  background: #DDD;
}
.car .wheel.front {
  left: 2.75rem;
}

.tree {
  position: absolute;
  width: 0.5rem;
  height: 1rem;
  background: inherit;
  top: -0.5rem;
}
.tree:after {
  content: "";
  position: absolute;
  bottom: 1rem;
  left: -0.75rem;
  height: 4rem;
  width: 2rem;
  background: inherit;
  border-radius: 3rem 3rem 2rem 2rem/8rem 8rem 4rem 4rem;
}

.bush {
  position: absolute;
  height: 2rem;
  width: 2rem;
  border-radius: 50%;
  background: inherit;
  box-shadow: 2.5rem -0.1rem 0 0.1rem #B6C997;
  transform: scale(0.8);
  top: -1rem;
}
.bush:before {
  content: "";
  position: absolute;
  left: 1rem;
  top: -0.5rem;
  height: 1.5rem;
  width: 1.5rem;
  border-radius: 50%;
  background: inherit;
  box-shadow: 1rem 0.25rem 0 0.25rem #B6C997;
}
.bush:after {
  content: "";
  position: absolute;
  left: 1rem;
  bottom: 0;
  height: 1.2rem;
  width: 2.25rem;
  background: inherit;
}

.house {
  position: absolute;
  left: 10rem;
  width: 4rem;
  height: 2rem;
  background: inherit;
  top: -2rem;
}
.house:after {
  content: "";
  position: absolute;
  bottom: 2rem;
  border-left: 2rem solid transparent;
  border-right: 2rem solid transparent;
  border-bottom: 1.5rem solid #E5D0BE;
}

.hill {
  position: absolute;
  background: #E4EFD2;
  width: 16rem;
  height: 8rem;
  border-radius: 50%;
  top: 4rem;
  left: 2rem;
}
.hill:after {
  content: "";
  position: absolute;
  width: 16rem;
  height: 6rem;
  background: inherit;
  border-radius: 50%;
  top: 1rem;
  left: 6rem;
}
.hill:before {
  content: "";
  position: absolute;
  width: 20rem;
  height: 8rem;
  background: inherit;
  border-radius: 50%;
  top: 1rem;
  left: -10rem;
}

.layer-0 {
  position: absolute;
  background: #999;
  width: 24rem;
  height: 1.5rem;
  top: 9rem;
  z-index: 25;
}

.layer-1 {
  position: absolute;
  background: #B6C997;
  width: 24rem;
  height: 1.5rem;
  top: 8.5rem;
  z-index: 20;
}
.layer-1 .chunk-1 {
  position: absolute;
  background: inherit;
  -webkit-animation: chunk 6s linear infinite;
          animation: chunk 6s linear infinite;
}
.layer-1 .chunk-1 div:nth-child(1) {
  left: 3rem;
}
.layer-1 .chunk-1 div:nth-child(2) {
  left: 6rem;
}
.layer-1 .chunk-1 div:nth-child(3) {
  left: 7rem;
}
.layer-1 .chunk-1 div:nth-child(4) {
  left: 12em;
}
.layer-1 .chunk-1 div:nth-child(5) {
  left: 15rem;
}
.layer-1 .chunk-1 div:nth-child(6) {
  left: 20rem;
}
.layer-1 .chunk-2 {
  position: absolute;
  background: inherit;
  transform: translateX(24rem);
  -webkit-animation: chunk 6s 3s linear infinite;
          animation: chunk 6s 3s linear infinite;
}
.layer-1 .chunk-2 div:nth-child(1) {
  left: 3rem;
}
.layer-1 .chunk-2 div:nth-child(2) {
  left: 6rem;
}
.layer-1 .chunk-2 div:nth-child(3) {
  left: 9rem;
}
.layer-1 .chunk-2 div:nth-child(4) {
  left: 11em;
}
.layer-1 .chunk-2 div:nth-child(5) {
  left: 17rem;
}
.layer-1 .chunk-2 div:nth-child(6) {
  left: 22rem;
}

.layer-2 {
  position: absolute;
  background: #E5D0BE;
  width: 24rem;
  height: 2rem;
  top: 8rem;
  z-index: 10;
}
.layer-2 .chunk-1 {
  position: absolute;
  background: inherit;
  -webkit-animation: chunk 12s linear infinite;
          animation: chunk 12s linear infinite;
}
.layer-2 .chunk-1 div:nth-child(1) {
  left: 3rem;
}
.layer-2 .chunk-1 div:nth-child(2) {
  left: 8rem;
}
.layer-2 .chunk-1 div:nth-child(3) {
  left: 13rem;
}
.layer-2 .chunk-2 {
  position: absolute;
  background: inherit;
  transform: translateX(24rem);
  -webkit-animation: chunk 12s 6s linear infinite;
          animation: chunk 12s 6s linear infinite;
}
.layer-2 .chunk-2 div:nth-child(1) {
  left: 3rem;
}
.layer-2 .chunk-2 div:nth-child(2) {
  left: 8rem;
}
.layer-2 .chunk-2 div:nth-child(3) {
  left: 13rem;
}
.layer-2 .chunk-2 div:nth-child(4) {
  left: 18rem;
}

@-webkit-keyframes chunk {
  0% {
    transform: translateX(24em);
  }
  100% {
    transform: translateX(-24em);
  }
}

@keyframes chunk {
  0% {
    transform: translateX(24em);
  }
  100% {
    transform: translateX(-24em);
  }
}
@-webkit-keyframes car-body {
  0%, 100% {
    transform: translate(0, 0);
  }
  25% {
    transform: translate(0, -0.05em);
  }
  75% {
    transform: translate(0, 0.05em);
  }
}
@keyframes car-body {
  0%, 100% {
    transform: translate(0, 0);
  }
  25% {
    transform: translate(0, -0.05em);
  }
  75% {
    transform: translate(0, 0.05em);
  }
}
@-webkit-keyframes car {
  0% {
    transform: translateX(-24em);
  }
  20%, 80% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(24em);
  }
}
@keyframes car {
  0% {
    transform: translateX(-24em);
  }
  20%, 80% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(24em);
  }
}
    </style>
</head>
<body>
  <div class="stripe"></div>
  <div class="center" style="display: flex; flex-direction: column; align-items: center;">
    <div class="card">
      <div class="dismiss"></div>
      <div class="illustration">
        <div class="car">
          <div class="body">
            <div class="body-front"></div>
            <div class="body-back"></div>
            <div class="window"></div>
          </div>
          <div class="front wheel"></div>
          <div class="back wheel"></div>
        </div>
        <div class="layer-0"></div>
        <div class="layer-1">
          <div class="chunk-1">
            <div class="tree"></div>
            <div class="tree"></div>
            <div class="bush"></div>
            <div class="tree"></div>
            <div class="tree"></div>
            <div class="tree"></div>
          </div>
          <div class="chunk-2">
            <div class="tree"></div>
            <div class="tree"></div>
            <div class="tree"></div>
            <div class="bush"></div>
            <div class="tree"></div>
            <div class="tree"></div>
          </div>
        </div>
        <div class="layer-2">
          <div class="chunk-1">
            <div class="house"></div>
            <div class="house"></div>
            <div class="house"></div>
          </div>
          <div class="chunk-2">
            <div class="house"></div>
            <div class="house"></div>
            <div class="house"></div>
            <div class="house"></div>
          </div>
        </div>
        <div class="hill"></div>
      </div>
      <div class="content">
        <h2 style="align-self: center;">
          Purchase Successful!
        </h2>
        <p>
          Your order will be delivered to your address as soon as possible.
        </p>
      </div>
    </div>
    <a href="customer_main.php" style="display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #4A148C; color: white; text-decoration: none; border-radius: 5px; text-align: center;">
      Return to Main Page
    </a>
  </div>
</body>
</html>
