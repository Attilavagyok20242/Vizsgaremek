const warriorSections = document.querySelectorAll('.warrior-story');

window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY;

    warriorSections.forEach(section => {
        section.style.backgroundPosition = `center ${scrollPosition * 0.5}px`;
    });

    const scrollingText = document.querySelector('.scrolling-text-legend');
    if (scrollingText) {
        if (scrollPosition > 100) {
            scrollingText.style.transform = `translateY(${scrollPosition * 0.2}px)`;
        } else {
            scrollingText.style.transform = 'translateY(0)';
        }
    }
});

const header = document.querySelector('header');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('sticky');
    } else {
        header.classList.remove('sticky');
    }
});

const menuIcon = document.getElementById('menuIcon');
const nav = document.querySelector('nav ul');
menuIcon.addEventListener('click', () => {
    nav.classList.toggle('active');
});

const heroSection = document.querySelector('.hero');
if (heroSection) {
    window.addEventListener('scroll', () => {
        let scroll = window.scrollY;
        heroSection.style.backgroundPosition = `center ${scroll * 0.3}px`;
    });
}

const flameButtons = document.querySelectorAll('.btn');
flameButtons.forEach(button => {
    button.addEventListener('mouseover', () => {
        button.style.boxShadow = '0 0 15px rgba(255, 204, 0, 0.8)';
        button.style.transform = 'scale(1.05)';
    });
    button.addEventListener('mouseout', () => {
        button.style.boxShadow = 'none';
        button.style.transform = 'scale(1)';
    });
});

const legendText = document.querySelector('.scrolling-text-legend');
window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY;
    if (legendText) {
        legendText.style.transform = `translateY(${scrollPosition * 0.3}px)`;
    }
});

const warriorStorySections = document.querySelectorAll('.warrior-story');

window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY;

    warriorStorySections.forEach(section => {
        section.style.backgroundPosition = `center ${scrollPosition * 0.3}px`;
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('myVideo');
    const playButton = document.getElementById('playButton');
    const caption = document.querySelector('.video-caption p');

    // Toggle play and pause when clicking the play button
    playButton.addEventListener('click', function () {
        if (video.paused) {
            video.play();
            playButton.style.display = 'none'; // Hide play button when video is playing
            caption.style.opacity = '1'; // Show caption when video starts
        } else {
            video.pause();
            playButton.style.display = 'block'; // Show play button when video is paused
            caption.style.opacity = '0'; // Hide caption when video is paused
        }
    });

    // Show the play button when video is paused (in case the video ended or was paused)
    video.addEventListener('pause', function () {
        playButton.style.display = 'block';
        caption.style.opacity = '0'; // Hide caption when paused
    });

    video.addEventListener('play', function () {
        playButton.style.display = 'none';
        caption.style.opacity = '1'; // Show caption when video is playing
    });
});

