$(function () {

    // La trimiterea formularului de contact 
    $(".formular-contact").on("submit", function (e) {
        e.preventDefault();

        let valid = true;

        // Ascunde mesajele de validare și notificările anterioare 
        $(".feedback-validare").hide();
        $("#msgSuccess").hide();
        $("#msgError").hide();

        // Verifică fiecare câmp din formular 
        $(this).find("input, textarea").each(function () {
            const rule = $(this).data("rule");
            const msg = $(this).data("msg");
            const val = $(this).val().trim();
            let error = false;

            if (rule === "required" && val === "") {
                error = true;
            } else if (rule === "email" && !/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(val)) {
                error = true;
            } else if (rule?.startsWith("minlen:")) {
                const min = parseInt(rule.split(":")[1]);
                if (val.length < min) {
                    error = true;
                }
            }

            if (error) {
                valid = false;
                $(this).next(".feedback-validare").text(msg).show();
            }
        });

        if (!valid) return;

        const form = $(this);

        // Trimite formularul prin AJAX
        $.ajax({
            type: "POST",
            url: "send_mail.php",
            data: form.serialize(),
            dataType: "json",
            success: function (res) {
                if (res.status === "success") {
                    $("#msgSuccess").text(res.message).fadeIn();
                    form[0].reset();
                } else {
                    $("#msgError").text(res.message).fadeIn();
                }
            },
            error: function () {
                $("#msgError").text("Eroare de rețea. Încearcă din nou.").fadeIn();
            }
        });
    });
});