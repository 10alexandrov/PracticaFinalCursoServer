<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel ="stylesheet" href= "{{asset('css/bootstrap.min.css')}}">
        <link rel ="stylesheet" href= "{{asset('storage/css/bootstrap.min.css')}}">

        <title>Laravel</title>

    </head>

    <style>

        * {
          box-sizing: border-box;
          }

          .info-container {
            padding-left: 22%;
            margin: 0 auto;
            width: 95%;
            }

          .desktop-menu {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
          }

          .AW-logo-mini {
            width:30%;
          }

          .wrapper {
          display: flex;
          margin: 0 0 8px 0;
          }

          .cta {
            display: flex;
            width: 250px;
            padding: 0 20px;
            text-decoration: none;
            font-family: 'Jost', sans-serif;
            font-size: 33px;
            color: white;
            background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
            transition: 1s;
            box-shadow: 6px 6px 0 black;
            transform: skewX(-15deg);
            justify-content: space-between;
          }

          .active {
            color: white;
            background: linear-gradient(to bottom, #3f31a5, #635acc, #3f31a5);
            transition: 1s;
            box-shadow: 6px 6px 0 black;
            transform: skewX(-15deg);
            justify-content: space-between;
          }


          .cta:focus {
           outline: none;
          }

          .cta:hover {
            transition: 0.5s;
            box-shadow: 10px 10px 0 #FBC638;
          }

          .cta span:nth-child(2) {
            transition: 0.5s;
            margin-right: 0px;
          }

          .cta:hover  span:nth-child(2) {
            transition: 0.5s;
            margin-right: 45px;
          }

          span {
            transform: skewX(15deg)
          }

          .desktop-menu-title {
            width: 190px;
            text-align: left;
          }

          span:nth-child(2) {
            width: 20px;
            margin-left: 30px;
            position: relative;
            top: 12%;
          }


          /**************SVG****************/

          path.one {
            transition: 0.4s;
            transform: translateX(-60%);
          }

          path.two {
            transition: 0.5s;
            transform: translateX(-30%);
          }

          .cta:hover path.three {
            animation: color_anim 1s infinite 0.2s;
          }

          .cta:hover path.one {
            transform: translateX(0%);
            animation: color_anim 1s infinite 0.6s;
          }

          .cta:hover path.two {
            transform: translateX(0%);
            animation: color_anim 1s infinite 0.4s;
          }

          #desktop-menu-admin-submenu, #desktop-menu-pedido-submenu {
            overflow: hidden; /* Скрыть содержимое, которое выходит за пределы */
            // height: 0; /* Начальная высота */
            transition: height 0.5s ease-out; /* Анимация для плавного раскрытия */
          }

          /* SVG animations */

          @keyframes color_anim {
            0% {
                fill: white;
            }
            50% {
                fill: #FBC638;
            }
            100% {
                fill: white;
            }
          }


.AW-logo-micro {
  width: 50px;
}

.navbar-mainbg{
  background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
  padding: 10px;
}


.hamburger {
  position: relative;
  display: inline-block;
  vertical-align: middle;
  cursor: pointer;
  width: 40px;
  height: 40px;
  border: 1px solid #ffffff;
  background: #fffFFF00;
  padding: 5px;
  border-radius: 8px; }

.btn__hamb {
  position: relative;
  display: block;
  width: 100%;
  height: 4px;
  background: #ffffff;
  cursor: pointer; }
  .btn__hamb div {
    width: 100%;
    height: 100%; }
  .btn__hamb:before, .btn__hamb:after {
    content: "";
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    background: #ffffff; }
  .btn__hamb:before {
    top: -8px; }
  .btn__hamb:after {
    top: 8px; }


    .active {
      color: white;
      background: linear-gradient(to bottom, #3f31a5, #635acc, #3f31a5);
      transition: 1s;
      justify-content: space-between;
    }

    .menuList {
      position: absolute;
      background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
      top: 70px;
      width:100%;
      padding: 20px;
      z-index: 10;
    }


    .mobile-menu {
        display: none;
    }

    .desctop-menu {
        display:flex;
    }

    @media screen and (max-width:1050px) {
  .info-container {
    padding-left: 28%;
    margin: 10px auto;
    width: 97%;
  }
}

@media screen and (max-width:850px) {
  .info-container {
    padding-left: 32%;
    margin: 10px auto;
    width: 99%;
  }

  .tablet-hidden {
        display: none;
    }
}

.desktop-version {
        display:block;
    }

@media screen and (max-width:767px) {
    .mobile-menu {
        display: block;
    }

    .desktop-version {
        display:none;
    }

    .cta-mobile {
        display: flex;
        width: 250px;
        padding: 0 20px;
        text-decoration: none;
        font-family: 'Jost', sans-serif;
        font-size: 33px;
        color: white;
        background:  #00000000;
        justify-content: space-between;
        border: none;
          }

    .info-container {
    margin: 0 auto;
    width: 98%;
    padding-left:0;
    }

    table, #btn-text {
    font-size: 2.5vw;
    }

}

@media screen and (max-width:576px) {
    table, #btn-text {
    font-size: 3vw;
    }

    .mobile-hidden {
        display: none;
    }
}

        </style>

<!-- Mobile version-->

<div class="mobile-menu w-100">

    <nav class="navbar navbar-expand-custom navbar-mainbg">
      <a class="navbar-brand navbar-logo ms-3" href="#">
        <img class="AW-logo-micro m-auto" src="https://omnigena.info/img/logo/1a_logotype-mini.png">
      </a>
      <button class="hamburger me-5" id="mobile-menu-btn" type="button" (click)="menuVisible ()">
        <div class="btn__hamb">
            <div></div>
        </div>
      </button>
    </nav>
      <div class="menuList d-none" id="menu-list">
          <ul class="navbar-nav ml-auto">
              <li  class="nav-item">
                  <a class="cta-mobile" id = "desktop-menu-admin" href="{{ route ('users.index')}}">Usuarios</a>
              </li>
              <li class="nav-item">
                  <a class="cta-mobile" id = "desktop-menu-admin" href="{{ route ('product.index')}}">Productos</a>
              </li>

              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cta-mobile" id="desktop-menu">Log Out </button>
                </form>
              </li>
          </ul>
      </div>

    <!-- Principio Content -->
    @yield ('contenido');
    </div>

</div>




<!-- Desctop version-->

<div class="desktop-version">
    <!-- Principio menu -->
    <div class="desktop-menu">
        <div class="d-flex pt-2 pb-2">
        <img class="AW-logo-mini m-auto" src="https://omnigena.info/img/logo/1a_logotype-mini.png">
        </div>

        <div class="wrapper">
            <a class="cta" id = "desktop-menu-admin" href='{{ route('users.index') }}'>
            <span class = "desktop-menu-title">Usuarios</span>
            <span>
                <svg width="40px" height="40px" viewBox="0 10 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                    <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                    <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                </g>
                </svg>
            </span>
            </a>
        </div>


        <div class="wrapper">
        <a class="cta" id = "desktop-menu-admin" href='/product'>
            <span class = "desktop-menu-title">Productos</span>
            <span>
                <svg width="40px" height="40px" viewBox="0 10 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                    <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                    <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                </g>
                </svg>
            </span>
        </a>
        </div>

        <div class="wrapper mt-5">
            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="cta" id="desktop-menu">
                <span class = "desktop-menu-title">Logout</span>
                <span class="mt-2">
                    <svg width="40px" height="40px" viewBox="0 10 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                        <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                        <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                    </g>
                    </svg>
                </span>
            </button>
            </form>
        </div>
    </div>

    <!-- Principio Content -->
    @yield ('contenido');

</div>

<script>

    let flag = false;
    menuButton = document.getElementById('mobile-menu-btn');

    menuButton.addEventListener ('click', (event) => {
        menu = document.getElementById('menu-list');
        if (!flag) {
            menu.classList.remove('d-none');
            menu.classList.add('d-block');
            flag = !flag;
        } else {
            menu.classList.remove('d-block');
            menu.classList.add('d-none');
            flag = !flag;
        }
    })

</script>
