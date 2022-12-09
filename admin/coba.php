<!DOCTYPE html>
<html>
<style>
    .clock {
        background: #ececec;
        width: 300px;
        height: 300px;
        margin: 8% auto 0;
        border-radius: 50%;
        border: 14px solid #333;
        position: relative;
        box-shadow: 0 2vw 4vw -1vw rgba(0, 0, 0, 0.8);
    }

    .dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #ccc;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        position: absolute;
        z-index: 10;
        box-shadow: 0 2px 4px -1px black;
    }

    .hour-hand {
        position: absolute;
        z-index: 5;
        width: 4px;
        height: 65px;
        background: #333;
        top: 79px;
        transform-origin: 50% 72px;
        left: 50%;
        margin-left: -2px;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
    }

    .minute-hand {
        position: absolute;
        z-index: 6;
        width: 4px;
        height: 100px;
        background: #666;
        top: 46px;
        left: 50%;
        margin-left: -2px;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        transform-origin: 50% 105px;
    }

    .second-hand {
        position: absolute;
        z-index: 7;
        width: 2px;
        height: 120px;
        background: gold;
        top: 26px;
        lefT: 50%;
        margin-left: -1px;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        transform-origin: 50% 125px;
    }

    span {
        display: inline-block;
        position: absolute;
        color: #333;
        font-size: 22px;
        font-family: 'Poiret One';
        font-weight: 700;
        z-index: 4;
    }

    .h12 {
        top: 30px;
        left: 50%;
        margin-left: -9px;
    }

    .h3 {
        top: 140px;
        right: 30px;
    }

    .h6 {
        bottom: 30px;
        left: 50%;
        margin-left: -5px;
    }

    .h9 {
        left: 32px;
        top: 140px;
    }

    .diallines {
        position: absolute;
        z-index: 2;
        width: 2px;
        height: 15px;
        background: #666;
        left: 50%;
        margin-left: -1px;
        transform-origin: 50% 150px;
    }

    .diallines:nth-of-type(5n) {
        position: absolute;
        z-index: 2;
        width: 4px;
        height: 25px;
        background: #666;
        left: 50%;
        margin-left: -1px;
        transform-origin: 50% 150px;
    }

    .info {
        position: absolute;
        width: 120px;
        height: 20px;
        border-radius: 7px;
        background: #ccc;
        text-align: center;
        line-height: 20px;
        color: #000;
        font-size: 11px;
        top: 200px;
        left: 50%;
        margin-left: -60px;
        font-family: "Poiret One";
        font-weight: 700;
        z-index: 3;
        letter-spacing: 3px;
        margin-left: -60px;
        left: 50%;
    }

    .date {
        top: 80px;
    }

    .day {
        top: 200px;
    }
</style>
<link rel="stylesheet" href="jam.css">

<body>

    <button onclick="variabl = setTimeout(func, 3000)">Click me</button>
    <button onclick="delat()">Stop execution</button>
    <p>Please click the button "Click me" and see what happens after 3 seconds.</p>
    <p>Try to stop the function execution by clicking the stop button before completing 3 seconds.</p>
    <input type="text" id="tmpe">
    <p id="tmpe2"></p>

    <br>
    <button onclick="exek()">Stop</button>
    <br>
    <br>
    <div class="jam" id="jam"></div>
    <div class="clock">
        <div>
            <div class="info date"></div>
            <div class="info day"></div>
        </div>
        <div class="dot"></div>
        <div>
            <div class="hour-hand"></div>
            <div class="minute-hand"></div>
            <div class="second-hand"></div>
        </div>
        <div>
            <span class="h3">3</span>
            <span class="h6">6</span>
            <span class="h9">9</span>
            <span class="h12">12</span>
        </div>
        <div class="diallines"></div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
    <script src="jam.js"></script>
    <script>
        function func() {
            alert("This message is displayed after 3 seconds!");
        }

        function dela() {
            t = setTimeout(func, 3000);
            t;
        }

        function delat() {
            clearTimeout(t);
        }

        function exek() {
            var i, b, c, f;
            i = document.getElementById("tmpe");
            b = i.value;
            if (b == "1") {
                i.setAttribute('value', "2");
                alert("2");
            } else if (b == "2") {
                i.setAttribute('value', "3");
                alert("3")
                dela();
            } else {
                i.setAttribute('value', "1");
            }
        }
    </script>
    <script>
        var dialLines = document.getElementsByClassName('diallines');
        var clockEl = document.getElementsByClassName('clock')[0];

        for (var i = 1; i < 60; i++) {
            clockEl.innerHTML += "<div class='diallines'></div>";
            dialLines[i].style.transform = "rotate(" + 6 * i + "deg)";
        }

        function clock() {
            var weekday = [
                    "Sunday",
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday"
                ],
                d = new Date(),
                h = d.getHours(),
                m = d.getMinutes(),
                s = d.getSeconds(),
                date = d.getDate(),
                month = d.getMonth() + 1,
                year = d.getFullYear(),

                hDeg = h * 30 + m * (360 / 720),
                mDeg = m * 6 + s * (360 / 3600),
                sDeg = s * 6,

                hEl = document.querySelector('.hour-hand'),
                mEl = document.querySelector('.minute-hand'),
                sEl = document.querySelector('.second-hand'),
                dateEl = document.querySelector('.date'),
                dayEl = document.querySelector('.day');

            var day = weekday[d.getDay()];

            if (month < 9) {
                month = "0" + month;
            }

            hEl.style.transform = "rotate(" + hDeg + "deg)";
            mEl.style.transform = "rotate(" + mDeg + "deg)";
            sEl.style.transform = "rotate(" + sDeg + "deg)";
            dateEl.innerHTML = date + "/" + month + "/" + year;
            dayEl.innerHTML = day;
        }

        setInterval("clock()", 100);
    </script>
</body>

</html>