window.addEventListener('load', () => {
  let secondary = document.querySelector('.site__title .secondary');
  if (secondary) {
    // let now = new Date();
    // let secs = now.getSeconds() + (60 * (now.getMinutes() + (60 * now.getHours())));
    //
    // let h = map(0, 86400, 0, 360, secs);
    let h = parseInt(Math.random()*360);
    secondary.style.setProperty('color', `hsl(${h}, 100%, 50%)`);
  }
});

let toggleInfo = () => {
  let info = document.querySelector('.info__contents');
  console.log(info);
  if (info) {
    info.classList.toggle('active');
  }
}

window.addEventListener('pointermove', (e) => {
  let x = e.clientX;
  let y = e.clientY;

  let secondary = document.querySelector('.site__title .secondary');
  if (secondary) {
    let xScale = map(0, window.innerWidth, -10, 10, x);
    let yScale = map(0, window.innerHeight, -10, 10, y);
    secondary.style.setProperty('transform', `translate(${xScale}px, ${yScale}px)`);
  }
});

let map = (x1, x2, y1, y2, x) => {
  return y1 + (y2 - y1) * ((x - x1) / (x2 - x1));
}
