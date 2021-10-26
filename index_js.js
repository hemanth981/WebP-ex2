function length_filter(el, len)
{
    console.log("Filter Starting...")
    var video_container = document.getElementById('videos')
    var videos = video_container.querySelectorAll("a")
    var i;
    // Small=> 0-45 mins
    // Medium=> 45-90 mins
    // Large=> >90 mins
    var min, max;
    min = -1;
    max = 99999;
    var small = document.getElementById('video_filter_s').checked
    var medium = document.getElementById('video_filter_m').checked
    var large = document.getElementById('video_filter_l').checked
    if(small) {
        min = 0;
        max = 45;
    }
    if(medium) {
        if(min == -1) {
            min = 45;
        }
        max = 90;
    }
    if(large) {
        if(min == -1) {
            min = 90;
        }
        max = 9999;
    }
    for(i=0;i<videos.length; ++i) {
        var video_borders = video_container.children
        // console.log(videos[i].attributes.vid_length.value)
        if(small && videos[i].attributes.vid_length.value > 0 && videos[i].attributes.vid_length.value < 45) {
          video_borders[i].style.display='block'
        }
        else if(medium && videos[i].attributes.vid_length.value >= 45 && videos[i].attributes.vid_length.value < 90) {
          video_borders[i].style.display='block'
        }
        else if(large && videos[i].attributes.vid_length.value >= 90 && videos[i].attributes.vid_length.value < 9999) {
          video_borders[i].style.display='block'
        }
        else{
          video_borders[i].style.display='none'
        }
    }
    // console.log(videos)
    // alert('hello')
    console.log("Filter Ending...")
    // console.log(el.checked)
    // if (el.checked == true) {
    //     document.getElementById('courses').style.visibility='hidden'
    //     console.log('hi1')
    // }
    // else {
    //     console.log('hi')
    //     document.getElementById('courses').style.visibility='visible';
    //     // alert('jhjsd')
    // }
}
function expand_navbar() {
    var x = document.getElementById("id1navig");
    if (x.className === "navigation-bar") {
      x.className += " responsive2";
    } else {
      x.className = "navigation-bar";
    }
  }

  function play_video(el, url)
  {
    document.getElementById('course_video').src = url;
    document.getElementById('player_complete').style.display='block';
  }

function display_classes() {
    document.getElementsByClassName('dropdown-content')[0].style.display='inline-block';
}
function hide_classes() {
    document.getElementsByClassName('dropdown-content')[0].style.display='none';
}
function display_regd_users() {
    document.getElementsByClassName('regd_users_dropdown')[0].style.display='inline-block';
}
function hide_regd_users() {
    document.getElementsByClassName('regd_users_dropdown')[0].style.display='none';
}
function display_user_details() {
    document.getElementsByClassName('user_details_dropdown')[0].style.display='inline-block';
}
function hide_user_details() {
    document.getElementsByClassName('user_details_dropdown')[0].style.display='none';
}

function showSearch(search_str) {
  // document.getElementById("search_dropdown").innerHTML = "";
    console.log(search_str);
    if (search_str.length == 0) {
      document.getElementById("search_dropdown").innerHTML = "";
      document.getElementsById('search_dropdown').style.display='inline-block';
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("search_dropdown").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "search.php?type=suggestions&q=" + search_str);
      xmlhttp.send();
    }
  }
