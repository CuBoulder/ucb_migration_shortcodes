document.addEventListener('DOMContentLoaded', function() {
    var expandContents = document.querySelectorAll('.expand-content');
    var expandTitles = document.querySelectorAll('a.expand-title span');
  
    expandContents.forEach(function(content) {
      content.style.display = 'none';
    });
  
    expandTitles.forEach(function(title) {
      title.classList.add('expand');
    });
  
    function toggleExpand(event) {
      event.preventDefault();
      var href = this.getAttribute('href');
      var content = document.querySelector(href);
      var span = this.querySelector('span');
  
      content.style.display = content.style.display === 'none' ? 'block' : 'none';
      span.classList.toggle('expand');
      span.classList.toggle('collapse');
      this.classList.toggle('expand-active');
      this.setAttribute('aria-expanded', content.style.display === 'none' ? 'false' : 'true');
    }
  
    document.querySelectorAll('a.expand-title').forEach(function(title) {
      title.addEventListener('click', toggleExpand);
    });
  
    var smallExpandContents = document.querySelectorAll('.small-expand-content, .tooltip-expand-content');
    var smallExpandTitles = document.querySelectorAll('a.small-expand-title');
  
    smallExpandContents.forEach(function(content) {
      content.style.display = 'none';
    });
  
    function toggleSmallExpand(event) {
      event.preventDefault();
      var href = this.getAttribute('href');
      var content = document.querySelector(href);
      var icon = this.querySelector('i.fa');
  
      content.style.display = content.style.display === 'none' ? 'block' : 'none';
      icon.classList.toggle('fa-plus-square');
      icon.classList.toggle('fa-minus-square');
      this.setAttribute('aria-expanded', content.style.display === 'none' ? 'false' : 'true');
    }
  
    smallExpandTitles.forEach(function(title) {
      title.addEventListener('click', toggleSmallExpand);
    });
  
    document.querySelectorAll('a.tooltip-expand-title').forEach(function(title) {
      title.addEventListener('click', function(event) {
        event.preventDefault();
        var href = this.getAttribute('href');
        var content = document.querySelector(href);
        var icon = this.querySelector('i.fa');
  
        content.style.display = 'block';
        icon.classList.remove('fa-plus-square');
        icon.classList.add('fa-minus-square');
        this.setAttribute('aria-expanded', 'true');
      });
    });
  
    document.querySelectorAll('a.close-tip').forEach(function(closeBtn) {
      closeBtn.addEventListener('click', function(event) {
        event.preventDefault();
        var href = this.getAttribute('href');
        var rel = this.getAttribute('rel');
        var content = document.querySelector(href);
        var icons = document.querySelectorAll('.' + rel + ' i.fa');
  
        content.style.display = 'none';
        icons.forEach(function(icon) {
          icon.classList.remove('fa-minus-square');
          icon.classList.add('fa-plus-square');
        });
        document.querySelector('.' + rel).setAttribute('aria-expanded', 'false');
      });
    });
  
    // Countup
    var counters = document.querySelectorAll('.counter');
    counters.forEach(function(counter) {
      var delay = parseInt(counter.getAttribute('data-delay'));
      var time = parseInt(counter.getAttribute('data-time'));
  
      function animateValue() {
        var start = 0;
        var end = parseInt(counter.innerText);
        var duration = time / delay;
        var range = end - start;
        var current = start;
        var increment = end > start ? 1 : -1;
        var stepTime = Math.abs(Math.floor(duration / range));
  
        var timer = setInterval(function() {
          current += increment;
          counter.innerText = current;
          if (current === end) {
            clearInterval(timer);
          }
        }, stepTime);
      }
  
      animateValue();
    });

    // Countdown
    var counters = document.querySelectorAll('.cu-countdown');
    counters.forEach(setInterval(function(counter) {
    
      var countDownDate = new Date(counter.innerText).getTime();
      // Get today's date and time
      var now = new Date().getTime();
    
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
    
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
      // Display the result in the element with id="demo"
      document.getElementById("demo").innerHTML = days + "d " + hours + "h "
      + minutes + "m " + seconds + "s ";
    
      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "DONE";
      }
    }, 1000));
  });