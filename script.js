document.addEventListener("DOMContentLoaded", function () {
    const messageInput = document.getElementById("message");
    const chatbox = document.getElementById("chatbox");
    const typingIndicator = document.getElementById("typing-indicator");
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    const contextMenu = document.getElementById("context-menu");
    let selectedMessageUser = "";

    let typing = false;
    let typingTimeout;

    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
    }
    
    document.addEventListener("DOMContentLoaded", function () {
        let themeButton = document.getElementById("dark-mode-toggle");
    
        themeButton.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");
    
            if (document.body.classList.contains("dark-mode")) {
                themeButton.textContent = "☀️ Világos mód";
            } else {
                themeButton.textContent = "🌙 Sötét mód";
            }
        });

    // Ellenőrizzük, hogy a sötét mód aktív-e
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
    }

    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
        } else {
            localStorage.setItem("darkMode", "disabled");
        }
    });
    let typingTimer;
const typingIndicator = document.getElementById("typing-indicator");

document.getElementById("message-input").addEventListener("input", () => {
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
            typingIndicator.innerText = users.length > 0 ? `${users.join(", ")} gépel...` : "";
        });
}

setInterval(getTypingStatus, 2000);

});


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

    function sendTypingStatus(isTyping) {
        fetch("chat.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `typing=${isTyping ? 1 : 0}`
        });
    }

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

            function setUsername() {
                let username = sessionStorage.getItem("username") || getCookie("username");
                
                if (!username) {
                    username = prompt("Adj meg egy felhasználónevet:");
                    if (!username) return;
            
                    fetch("chat.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "username=" + encodeURIComponent(username)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.username) {
                            sessionStorage.setItem("username", data.username);
                            document.cookie = `username=${data.username}; path=/`;
                        }
                    })
                    .catch(error => console.error("Hiba a felhasználónév beállításakor:", error));
                }
            }
            
            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
                return "";
            }
            
            
            

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
    document.addEventListener("DOMContentLoaded", function () {
        let themeButton = document.getElementById("theme-toggle");
    
        themeButton.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");
    
            if (document.body.classList.contains("dark-mode")) {
                themeButton.textContent = "Világos mód";
            } else {
                themeButton.textContent = "Sötét mód";
            }
        });
    });    

    document.getElementById("report-message").addEventListener("click", function () {
        alert("Az üzenetet jelentetted az adminoknak!");
    });
});
