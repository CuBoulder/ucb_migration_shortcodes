document.addEventListener('DOMContentLoaded', function () {
  var expandContents = document.querySelectorAll('.expand-content');
  var expandTitles = document.querySelectorAll('a.expand-title span');

  expandContents.forEach(function (content) {
    content.style.display = 'none';
  });

  expandTitles.forEach(function (title) {
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

  document.querySelectorAll('a.expand-title').forEach(function (title) {
    title.addEventListener('click', toggleExpand);
  });

  var smallExpandContents = document.querySelectorAll('.small-expand-content, .tooltip-expand-content');
  var smallExpandTitles = document.querySelectorAll('a.small-expand-title');

  smallExpandContents.forEach(function (content) {
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

  smallExpandTitles.forEach(function (title) {
    title.addEventListener('click', toggleSmallExpand);
  });

  document.querySelectorAll('a.tooltip-expand-title').forEach(function (title) {
    title.addEventListener('click', function (event) {
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

  document.querySelectorAll('a.close-tip').forEach(function (closeBtn) {
    closeBtn.addEventListener('click', function (event) {
      event.preventDefault();
      var href = this.getAttribute('href');
      var rel = this.getAttribute('rel');
      var content = document.querySelector(href);
      var icons = document.querySelectorAll('.' + rel + ' i.fa');

      content.style.display = 'none';
      icons.forEach(function (icon) {
        icon.classList.remove('fa-minus-square');
        icon.classList.add('fa-plus-square');
      });
      document.querySelector('.' + rel).setAttribute('aria-expanded', 'false');
    });
  });

  // Countdown
  var counters = document.querySelectorAll('.cu-countdown');
  for (const counter of counters) {
    var countDownDate = new Date(counter.innerText).getTime();
    var endDate = new Date(countDownDate);


    var now = new Date().getTime();
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var daysHTML = "<div class='countdown-days'><span class = 'countdown-value'>" + days + "</span><span class = 'countdown-label'> Days</span></div>";
    if (days == 1) {
      var daysHTML = "<div class='countdown-days'><span class = 'countdown-value'>" + days + "</span><span class = 'countdown-label'> Day</span></div>";
    }
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var hoursHTML = "<div class='countdown-hours'><span class = 'countdown-value'>" + hours + "</span><span class = 'countdown-label'> Hours</span></div>";
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var minutesHTML = "<div class='countdown-minutes'><span class = 'countdown-value'>" + minutes + "</span><span class = 'countdown-label'> Minutes</span></div>";
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    var secondsHTML = "<div class='countdown-seconds'><span class = 'countdown-value'>" + seconds + "</span><span class = 'countdown-label'> Seconds</span></div>";
    var srOnlyCountdown = document.createElement("div");
    srOnlyCountdown.classList.add('sr-only');
    srOnlyCountdown.innerHTML = "It is " + days + " days until " + endDate.toDateString();

    counter.innerHTML = daysHTML + "<div class='countdown-bottom'>" + hoursHTML + minutesHTML + secondsHTML + "</div>";
    counter.after(srOnlyCountdown);


    setInterval(function () {
      var now = new Date().getTime();
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var daysHTML = "<div class='countdown-days'><span class = 'countdown-value'>" + days + "</span><span class = 'countdown-label'> Days</span></div>";
      if (days == 1) {
        var daysHTML = "<div class='countdown-days'><span class = 'countdown-value'>" + days + "</span><span class = 'countdown-label'> Day</span></div>";
      }
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var hoursHTML = "<div class='countdown-hours'><span class = 'countdown-value'>" + hours + "</span><span class = 'countdown-label'> Hours</span></div>";
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var minutesHTML = "<div class='countdown-minutes'><span class = 'countdown-value'>" + minutes + "</span><span class = 'countdown-label'> Minutes</span></div>";
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      var secondsHTML = "<div class='countdown-seconds'><span class = 'countdown-value'>" + seconds + "</span><span class = 'countdown-label'> Seconds</span></div>";

      counter.innerHTML = daysHTML + "<div class='countdown-bottom'>" + hoursHTML + minutesHTML + secondsHTML + "</div>";


      if (distance < 0) {
        clearInterval(x);
        counter.innerHTML = "DONE";
      }
    }, 1000);
  }
});