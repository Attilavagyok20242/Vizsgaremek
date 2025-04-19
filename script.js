document.addEventListener("DOMContentLoaded", function () {
    const messageInput = document.getElementById("message");
    const chatbox = document.getElementById("chatbox");
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    const contextMenu = document.getElementById("context-menu");
    let selectedMessageUser = "";

    // Sötét mód ellenőrzése
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
        document.body.classList.remove("light-mode");
        darkModeToggle.innerHTML = "☀️ Világos mód";
    } else {
        document.body.classList.add("light-mode");
        darkModeToggle.innerHTML = "🌙 Sötét mód";
    }

    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");
        document.body.classList.toggle("light-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
            darkModeToggle.innerHTML = "☀️ Világos mód";
        } else {
            localStorage.setItem("darkMode", "disabled");
            darkModeToggle.innerHTML = "🌙 Sötét mód";
        }
    });

    // Üzenet küldés
    window.sendMessage = function () {
        let message = messageInput.value.trim();
        if (message === "") return;

        fetch("chat.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `message=${encodeURIComponent(message)}`
        }).then(() => {
            messageInput.value = "";
        });
    };

    function updateChat() {
        fetch("chat.php?get_messages=1")
            .then(response => response.text())
            .then(data => {
                chatbox.innerHTML = data;
                chatbox.scrollTop = chatbox.scrollHeight;

                document.querySelectorAll(".message").forEach(msg => {
                    if (msg.getAttribute("data-user") === "<?php echo $_SESSION['username']; ?>") {
                        msg.classList.add("my-message");
                    } else {
                        msg.classList.add("other-message");
                    }
                });
            });
    }

    setInterval(updateChat, 1000);

    // Kontextus menü és privát üzenet funkciók
    document.addEventListener("contextmenu", function (event) {
        event.preventDefault();
        let target = event.target.closest(".message");
        if (target) {
            selectedMessageUser = target.getAttribute("data-user");
            contextMenu.style.top = `${event.pageY}px`;
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.display = "block";
        }
    });

    document.addEventListener("click", function () {
        contextMenu.style.display = "none";
    });

    document.getElementById("private-message").addEventListener("click", function () {
        let privateMsg = prompt(`Írj privát üzenetet ${selectedMessageUser} számára:`);
        if (privateMsg) {
            fetch("chat.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `private_message=${encodeURIComponent(privateMsg)}&recipient=${selectedMessageUser}`
            });
        }
    });

    document.getElementById("report-message").addEventListener("click", function () {
        alert("Az üzenetet jelentetted az adminoknak!");
    });
});
