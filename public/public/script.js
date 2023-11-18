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
            const availabilityMsg = document.querySelector(".availability-msg");
            const reservationBtn = document.getElementById("reservation-btn");

            if (data.available) {
                availabilityMsg.textContent = "Este horário está disponível!";
                availabilityMsg.classList.remove("text-red-700");
                availabilityMsg.classList.add("text-green-500");
                reservationBtn.removeAttribute("disabled");
            } else {
                availabilityMsg.textContent =
                    "Este horário não está disponível.";
                availabilityMsg.classList.remove("text-green-500");
                availabilityMsg.classList.add("text-red-700");
                reservationBtn.setAttribute("disabled", true);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
});
