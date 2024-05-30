$(document).ready(function (e) {
    $(document).on("click", ".star", function () {
        // Toggle l'état rempli/vide de l'étoile
        let filled = !$(this).data("filled");
        $(this).data("filled", filled);
        // Récupérer l'ID du joueur associé
        let spartanId = $(this).data("spartiate-id");
        // Mettre à jour l'image en fonction de l'état rempli/vide
        let imageUrl = filled ? "/assets/images/fullStar.svg" : "/assets/images/emptyStar.svg";
        $(this).attr("src", imageUrl);

        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {
                action: "changeStar",
                spartanId: spartanId
            },
            dataType: "json",
            success: function (response) {
            }
        });
    });

    function handleSearch(inputSelector) {
        $(inputSelector).on('input', function () {
            // Récupère ce qui est écrit dans la barre de recherche
            let searchTerm = $(this).val();

            if (searchTerm.length > 0) {
                // Envoie la requête Ajax
                $.ajax({
                    type: "POST",
                    url: "/index.php",
                    data: {
                        action: inputSelector === "#searchQuestion" ? "searchQuestion" : "searchSpartan",
                        searchTerm: searchTerm
                    },
                    success: function (result) {
                        // Affiche le résultat de la recherche
                        if (result === "")
                            result = "Aucun résultat";
                        $('.result').hide();
                        $('.searchedResult').show().html(result);
                    }
                });
            } else {
                $('.searchedResult').hide();
                $('.result').show();
            }
        });
    }

// Appeler la fonction pour chaque champ de recherche spécifique
    handleSearch("#searchQuestion");
    handleSearch("#searchSpartan");

    $("#verificationForm").submit(function (e) {
        e.preventDefault(); //empêcher une action par défaut
        // Récupérer l'URL du formulaire et la méthode
        let form_method = $(this).attr("method");
        // Encoder les éléments du formulaire et ajouter la letiable action
        let form_data = $(this).serialize()
        // Effectuer la requête AJAX
        $.ajax({
            url: "/index.php",
            type: form_method,
            data: form_data
        }).done(function (response) {
            console.log(response)
            if (response.success) {
                // Si l'authentification est réussie, changer l'URL et recharger la page
                console.log(response)
                window.location.href = response.url;
            } else {
                // Si l'authentification échoue, afficher l'erreur
                $("#res").html(response.error);
            }
        });
    });

    $("#form").submit(function (e) {
        e.preventDefault(); //empêcher une action par défaut
        // Récupérer l'URL du formulaire et la méthode
        let form_method = $(this).attr("method");
        // Encoder les éléments du formulaire et ajouter la letiable action
        let form_data = new FormData(this);
        // Effectuer la requête AJAX
        $.ajax({
            url: "/index.php",
            type: form_method,
            data: form_data,
            contentType: false,
            processData: false
        }).done(function (response) {
            window.location.href = response;
        });
    });

    $(document).on("click", ".actionButton", function () {
        let action = $(this).data("action");
        let id = $(this).data("id");
        // Effectuer la requête AJAX
        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {
                action: action,
                id: id,
            },
        }).done(function (response) {
            if (response !== "")
                window.location.href = response;
        });
    });

    // D
    $(document).on("click", ".deleteButton", function () {
        updateRanking();
    });


    $(".callActionButton").on("click", function () {
        let buttonConfirmDelete = $('.actionButton');
        buttonConfirmDelete.data('id', $(this).data("id"));
    });

    //choix du spartiate avant le jeu
    $(".spartCard").on("click", function () {
        let id = $(this).data("id");
        // Effectuer la requête AJAX
        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {
                action: "setSessionSpart",
                spartanId: id,
            },
        }).done(function (response) {
            location.reload();
        });
    });

    $(".buttonWS").on("click", function () {
        let action = $(this).data("action");
        // Effectuer la requête AJAX
        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {
                action: action,
            },
        }).done(function (response) {
            if (response === "Vous n\'avez pas les droits administratifs nécessaires.") {
                alert(response);
            } else {
                sendMessage(response);
            }
            setTimeout(updateRanking, 1000);
            console.log("updateRanking");
        });
    });

});

function updateRanking() {
    $.ajax({
        type: "POST",
        url: "/index.php",
        data: {
            action: "showRanking",
        },
    }).done(function (response) {
        $('#ranking').html(response);
    });
}

function getSessionCode() {
    $.ajax({
        type: "POST",
        url: "/index.php",
        data: {
            action: "getSessionCode",
        },
    }).done(function (response) {
        $('#code').html(response.toString());
    });
}

function animationHelper() {
    console.log("animationHelper")
    if( document.getElementById('tutorial-hand').style.display === 'none'){
        document.getElementById('tutorial-hand').style.display = 'block';
    } else {
        document.getElementById('tutorial-hand').style.display = 'none';
    }
}

if (window.location.pathname === "/users") {
    getSessionCode()
    updateRanking()
}
