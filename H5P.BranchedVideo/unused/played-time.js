<!DOCTYPE html>
<html>
<body>
<p id='text'> hello </p>
<video width="320" height="240" id='video' controls>
  <source src="movie.mp4" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">
</video>
<div id="sliderDiv">
  <input type="range" min="0" max="100" value="0" class="slider" id="slider">
</div>
<script>
var array = [[0,0]];
var video = document.getElementById('video');
  var text = document.getElementById('text');
  var slider = document.getElementById('slider');
  video.ontimeupdate = function(){
      var time = video.currentTime;
      var roundedTime = Math.round( time * 10 ) / 10;
      var index = getIndex(roundedTime, array);
      slider.value = (roundedTime / 12 ) *100;
      updateArray(roundedTime, index, array);
      text.innerHTML = printArray(array);
  }
  slider.addEventListener('mouseup', function(){
      var time = (slider.value / 100) * 12;
          var roundedTime = Math.round( time * 10 ) / 10;
          video.currentTime = roundedTime;

          var index = getIndex(roundedTime, array);
          if (index == -1){
            insertPair(roundedTime, array);
          }

  })

  // returns index of pair where currentVideo is in between
  // if none found, return -1
  // parameters: time, array of pair of times
  function getIndex( time, arr){
      var length = arr.length;
      for (var index = 0 ; index<length; index++){
        var bottom = arr[index][0];
          var top = arr[index][1];
          if (time <= top + 1 && time >= bottom){
            return index;
          }
      }
      return -1;
  }

  // insert a new pair of played time
  // called if current time isn't between any pairs
  // keeps it ordered
  function insertPair(time, arr){
    var roundedTime = Math.round( time * 10 ) / 10;
    var length = arr.length;
      for (var index = 0; index<length-1; index++){
        var currentTop = arr[index][1];
          var nextBottom = arr[index +1][0];
          if ( time > currentTop && time < nextBottom){
            arr.push([roundedTime, roundedTime + 0.1]);
              for (var i = index+1; i < arr.length; i++){
                var temp = arr[arr.length-1]; //back
                  arr[arr.length-1] = arr[i];
                  arr[i] = temp;
              }
              console.log('push between');
              return;
          }
      }
      arr.push([roundedTime,roundedTime +0.1]);
      console.log('push to back');
  }

  // updates existing array with current time
  // parameter: time, index we are currently in, array of pairs
  // updates top of pair if current time is greater than it
  // merges with next pair if exists and current time greater than next bottom
  function updateArray(time, index, array){
    var top = array[index][1];
      if (time > top){
      array[index][1] = time;
       }
      var next = array[index+1];
      if (next){
        var nextBottom = next[0];
        if(nextBottom < time){
          array[index][1] = array[index+1][1];
            array.splice(index+1 ,1);
        }
      }
  }


  // returns the array to print just to test
  function printArray(arr){
    var str = '';
      var length = arr.length;
      for (var i = 0; i<length;i++){
        str += '[' + arr[i] + '] ';
      }
      return str;
  }


// versions: lower the better
// https://www.w3schools.com/code/tryit.asp?filename=FSRFB5S115RO
// https://www.w3schools.com/code/tryit.asp?filename=FSRFHQWGT02L
// https://www.w3schools.com/code/tryit.asp?filename=FSRFNIKY7PSU
// https://www.w3schools.com/code/tryit.asp?filename=FSRFYBEGMPJS
// https://www.w3schools.com/code/tryit.asp?filename=FSRNO7LLL5UW

</script>

</body>
</html>
