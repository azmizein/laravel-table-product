document.addEventListener("DOMContentLoaded", () => {
    const button = document.getElementById("sync-products");

    if (!button) {
        return;
    }

    const messageContainer = document.createElement("div");
    messageContainer.classList.add("mt-3");
    button.parentNode?.appendChild(messageContainer);

    button.addEventListener("click", async () => {
        const url = button.dataset.syncUrl;
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        button.disabled = true;
        button.textContent = "Syncing...";
        messageContainer.innerHTML = "";

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ limit: 20 }),
            });

            if (!response.ok) {
                throw new Error("Failed to sync products");
            }

            const data = await response.json();
            const syncedCount = Array.isArray(data.data) ? data.data.length : 0;
            messageContainer.innerHTML = `<div class="alert alert-success mt-3">Synced ${syncedCount} products successfully. Refresh to see updates.</div>`;
        } catch (error) {
            console.error(error);
            messageContainer.innerHTML =
                '<div class="alert alert-danger mt-3">Unable to sync products. Please try again.</div>';
        } finally {
            button.disabled = false;
            button.textContent = "Sync Products";
        }
    });
});
