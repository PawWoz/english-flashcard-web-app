let navbar = document.querySelector('.header .navbar');
        let menu = document.querySelector('#menu-btn');

        menu.onclick = () => {
            menu.classList.toggle('fa-times');
            navbar.classList.toggle('active');
        }