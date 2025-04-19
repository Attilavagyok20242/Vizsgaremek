document.addEventListener("DOMContentLoaded", function () {
    const messageInput = document.getElementById("message");
    const chatbox = document.getElementById("chatbox");
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    const contextMenu = document.getElementById("context-menu");
    let selectedMessageUser = "";

    // 🌗 Sötét mód beállítás
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

    // 🟢 Szekció: belépési adatok küldése
    function initSession() {
        const username = sessionStorage.getItem("username");
        const chatroom = sessionStorage.getItem("chatroom");
        if (!username || !chatroom) return;

        const formData = new URLSearchParams();
        formData.append("username", username);
        formData.append("chatroom", chatroom);

        fetch("assets/chat.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData.toString()
        }).catch(console.error);
    }

    initSession();

    // ✉️ Üzenet küldése
    window.sendMessage = function () {
        const message = messageInput.value.trim();
        if (message === "") return;

        fetch("assets/chat.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `message=${encodeURIComponent(message)}`
        })
        .then(() => {
            messageInput.value = "";
        })
        .catch(console.error);
    };

    // 🔁 Üzenetek frissítése
    function updateChat() {
        fetch("assets/chat.php?get_messages=1")
            .then(response => response.text())
            .then(data => {
                chatbox.innerHTML = "";

                const currentUser = sessionStorage.getItem("username");
                const lines = data.split("\n");

                lines.forEach(line => {
                    if (line.trim() === "") return;
                    const temp = document.createElement("div");
                    temp.innerHTML = line;

                    const p = temp.querySelector("p");
                    if (!p) return;

                    const div = document.createElement("div");
                    const username = p.querySelector("strong")?.textContent ?? "";
                    div.classList.add("message");
                    div.setAttribute("data-user", username);

                    if (username === currentUser) {
                        div.classList.add("my-message");
                    } else {
                        div.classList.add("other-message");
                    }

                    div.innerHTML = p.innerHTML;
                    chatbox.appendChild(div);
                });

                chatbox.scrollTop = chatbox.scrollHeight;
            })
            .catch(console.error);
    }

    setInterval(updateChat, 1000);

    // 📜 Kontextus menü jobb klikkre
    document.addEventListener("contextmenu", function (event) {
        const target = event.target.closest(".message");
        if (target) {
            event.preventDefault();
            selectedMessageUser = target.getAttribute("data-user");

            if (selectedMessageUser) {
                contextMenu.style.top = `${event.pageY}px`;
                contextMenu.style.left = `${event.pageX}px`;
                contextMenu.style.display = "block";
            }
        }
    });

    // ⛔ Kontextus menü elrejtése klikkre vagy ESC-re
    document.addEventListener("click", function () {
        contextMenu.style.display = "none";
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            contextMenu.style.display = "none";
        }
    });

    // 🔐 Privát üzenet küldése
    document.getElementById("private-message").addEventListener("click", function () {
        if (!selectedMessageUser) return;

        const privateMsg = prompt(`Írj privát üzenetet ${selectedMessageUser} számára:`);
        if (privateMsg && privateMsg.trim() !== "") {
            fetch("assets/chat.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `private_message=${encodeURIComponent(privateMsg)}&recipient=${encodeURIComponent(selectedMessageUser)}`
            })
            .catch(console.error);
        }
    });

    // 🚨 Üzenet jelentése
    document.getElementById("report-message").addEventListener("click", function () {
        alert("Az üzenetet jelentetted az adminoknak!");

        // Ezt kiegészítheted mentéssel:
        // fetch("report.php", { ... });
    });
});
