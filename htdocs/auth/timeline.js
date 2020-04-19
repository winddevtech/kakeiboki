//スマホフリック
class RoadBoxState {
  constructor(targetElem){
    this.roadbox = targetElem;
    this.amount = 0;
    this.minAmount = 0;
    this.maxAmount = 0;
  }

  start(className){
    this.roadbox.classList.add(className);
    this.minAmount = this.roadbox.getBoundingClientRect().top + window.pageYOffset;
    this.maxAmount = this.minAmount + 50;
  }

  move(){
    if (this.minAmount + this.amount < this.maxAmount) {
      this.amount += 1;
      this.roadbox.style.paddingTop = this.amount + 'px';
    }
  }

  end (className) {
    this.roadbox.removeAttribute('style');
    this.amount = 0;
    this.roadbox.classList.remove(className);
  }
}

class UserAgent {
  static isMobile(){
    var ua = window.navigator.userAgent.toLowerCase();

    if (ua.indexOf('iphone') > -1) {
      return true;
    }
    if (ua.indexOf('ipad') > -1) {
      return true;
    }
    if (ua.indexOf('android') > -1) {
      return true;
    }
    return false;
  }
}
var CLICK = 'click';
var RESIZE = 'resize';
var TOUCHSTART = 'touchstart';
var TOUCHMOVE = 'touchmove';
var TOUCHEND = 'touchend';
var SCROLL = 'scroll';
var roadbox = document.querySelector('#is-timelineRoad__infoBox');

if (UserAgent.isMobile()) {
  var rbs = new RoadBoxState(roadbox);
  roadbox.addEventListener(TOUCHSTART, function(){
    rbs.start('timelineRoad__infoBox--state_touch');
  }, false);
  roadbox.addEventListener(TOUCHMOVE, function(){
    rbs.move();
  }, false);
  roadbox.addEventListener(TOUCHEND, function(){
    rbs.end('timelineRoad__infoBox--state_touch');
  }, false);
} else {
  roadbox.classList.add('timelineRoad__infoBox--device_pc');
}


class Timeline {
  constructor (){

  }

  isSearchNew(){

  }

  getData(){
  }

}

//新しいタイムラインはあるか

//新しいタイムラインがあればデータを取得

//データを読み込む

//タイムラインを表示
