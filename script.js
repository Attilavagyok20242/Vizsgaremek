document.addEventListener("DOMContentLoaded", function () {
    const messageInput = document.getElementById("message");
    const chatbox = document.getElementById("chatbox");
    const typingIndicator = document.getElementById("typing-indicator");
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    const contextMenu = document.getElementById("context-menu");
    let selectedMessageUser = "";

    let typing = false;
    let typingTimeout;

    // Sötét mód ellenőrzése
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
        darkModeToggle.innerHTML = "☀️ Világos mód";
    }

    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
            darkModeToggle.innerHTML = "☀️ Világos mód";
        } else {
            localStorage.setItem("darkMode", "disabled");
            darkModeToggle.innerHTML = "🌙 Sötét mód";
        }
    });

    let typingTimer;

    document.getElementById("message").addEventListener("input", () => {
        clearTimeout(typingTimer);
        sendTypingStatus(1);
        typingTimer = setTimeout(() => sendTypingStatus(0), 3000);
    });

    function sendTypingStatus(isTyping) {
        fetch("chat.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "typing=" + isTyping
        });
    }

    function getTypingStatus() {
        fetch("chat.php?get_typing")
            .then(response => response.json())
            .then(users => {
                typingIndicator.innerText = users.length > 0 ? `${users.join(", ")} éppen gépel...` : "";
            });
    }

    setInterval(getTypingStatus, 2000);

    messageInput.addEventListener("input", function () {
        if (!typing) {
            typing = true;
            sendTypingStatus(true);
        }
        clearTimeout(typingTimeout);
        typingTimeout = setTimeout(() => {
            typing = false;
            sendTypingStatus(false);
        }, 2000);
    });

    window.sendMessage = function () {
        let message = messageInput.value.trim();
        if (message === "") return;

        fetch("chat.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `message=${encodeURIComponent(message)}`
        }).then(() => {
            messageInput.value = "";
            sendTypingStatus(false);
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

        fetch("chat.php?get_typing=1")
            .then(response => response.text())
            .then(data => {
                typingIndicator.innerHTML = data ? `<em>${data} éppen gépel...</em>` : "";
            });
    }

    setInterval(updateChat, 1000);

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
