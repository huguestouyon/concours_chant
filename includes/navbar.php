<header class="header">
        <nav class="navbar">
            <a href="index.php" class="nav-logo"><img class="logo-img" src="images\Les Voix de l’Audomarois.svg" alt="logo voix de l'audomarois"></a>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Admin</a>
                </li>
                <li class="nav-item">
                    <a href="api.php" class="nav-link">Mon Suivi</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="deconnexion.php" class="nav-link"><i class="color-link text-dark fa-solid fa-power-off"></i></a>
                </li>
            </ul>
            <div class="hamburger">
                <span class="bar bar1"></span>
                <span class="bar bar2"></span>
                <span class="bar bar3"></span>
            </div>
        </nav>
</header>


<script>
    const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

const bar1 = document.querySelector('.bar1');
const bar2 = document.querySelector('.bar2');
const bar3 = document.querySelector('.bar3');
hamburger.addEventListener("click", mobileMenu);

function mobileMenu() {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
}

hamburger.addEventListener('mouseover', () =>{
        bar1.style.background = "#85339b";
        bar2.style.background = "#85339b";
        bar3.style.background = "#85339b";
    }
)

hamburger.addEventListener('mouseout', () =>{
        bar1.style.background = "#000";
        bar2.style.background = "#000";
        bar3.style.background = "#000";
    }
)
</script>




