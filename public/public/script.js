document.getElementById("res_date").addEventListener("change", function () {
    const selectedDateTime = new Date(this.value);
    const selectedDate = selectedDateTime.toISOString().slice(0, 10);
    const selectedTime = selectedDateTime.toTimeString().slice(0, 5);

    console.log("Selected Date:", selectedDate);
    console.log("Selected Time:", selectedTime);

    fetch("/check-availability", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            selectedDate: selectedDate,
            selectedTime: selectedTime,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            const availabilityMsg = document.getElementById("availability-msg");

            if (data.available) {
                availabilityMsg.textContent = "";
                document
                    .getElementById("reservation-btn")
                    .removeAttribute("disabled");
            } else {
                availabilityMsg.textContent =
                    "Este horário não está disponível.";
                document
                    .getElementById("reservation-btn")
                    .setAttribute("disabled", true);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
});
