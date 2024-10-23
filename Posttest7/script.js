const homeLink = document.getElementById("home-link");
const aboutLink = document.getElementById("about-link");
const weaponsLink = document.getElementById("weapons-link");

const homePage = document.getElementById("home");
const aboutPage = document.getElementById("about");
const weaponsPage = document.getElementById("weapons");

homeLink.addEventListener("click", () => {
    homePage.style.display = "block";
    aboutPage.style.display = "none";
    weaponsPage.style.display = "none";
});

aboutLink.addEventListener("click", () => {
    homePage.style.display = "none";
    aboutPage.style.display = "block";
    weaponsPage.style.display = "none";
});

weaponsLink.addEventListener("click", () => {
    homePage.style.display = "none";
    aboutPage.style.display = "none";
    weaponsPage.style.display = "block";
});

const infoForm = document.getElementById("info-form");
const resultUsername = document.getElementById("result-username");
const resultAge = document.getElementById("result-age");
const resultPassword = document.getElementById("result-password");

window.onload = () => {
    resultUsername.textContent = document.getElementById("hidden-username").value;
    resultAge.textContent = document.getElementById("hidden-age").value;
    resultPassword.textContent = ""; 
};

const hamburger = document.getElementById("hamburger");
const nav = document.querySelector("nav");

hamburger.addEventListener("click", () => {
    nav.classList.toggle("active");
});
