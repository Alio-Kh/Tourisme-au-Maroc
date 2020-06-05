(function() {
    //start likes
    document.querySelectorAll('a.js-like').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.href;
                const span = this.querySelector('span.js-liks');
                const icon = this.querySelector('i');
                axios.get(url).then(function(response) {
                    const likes = response.data.likes;
                    if (span != null) {
                        span.textContent = likes;
                    }
                    if (icon.classList.contains('fas')) {
                        icon.classList.replace('fas', 'far');
                    } else {
                        icon.classList.replace('far', 'fas');
                    }
                }).catch(function(error) {
                    console.log(error);
                    if (error.response.status == 403) {
                        swal({
                            title: "Opsss!",
                            text: "vous devez etre connecte!",
                            icon: "warning",
                            button: "Ok!",
                        });
                    } else {

                    }
                })


            })
        })
        //end 

    //file input
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    //end

    //start  commentaire

    document.querySelector('.AjaxForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formD = new FormData()
        formD.append('comentaire', $('#comentaire').val());
        formD.append('ville', $('#ville').val());
        formD.append('file', document.getElementById('customFile').files[0]);
        var contentType = {
            headers: {
                "content-type": "multipart/form-data"
            }
        };
        axios.post($(".AjaxForm").attr('action'), formD, contentType).then(function(response) {
            const $error = response.data.error;
            const newFilename = response.data.newFilename;
            if ($error == "empty" && newFilename == "empty") {
                $('#error').hide();
                $('#comentaires').append('<div id="error"class="alert alert-danger" role="alert"><strong>il faut remplir au moin un champ !!</strong>');
            } else {
                const comentaire = response.data.comentaire;
                const nom = response.data.nom;
                const prenom = response.data.prenom;

                $('#comentaires').append("<h4>" + nom + " " + prenom + "</h4>");
                if ($error != "empty") {
                    $('#comentaires').append("<p>" + comentaire + "</h>");
                    $('#comentaire').val("");
                }
                if (newFilename != "empty") {
                    const assetsBaseDir = "{{ asset('img/comentaire/') }}";
                    $('#comentaires').append('<div class="container"><img style="height:200px; width:200px ;" src="' + assetsBaseDir + newFilename + '"></div>');
                }
                $('#comentaires').append('<div id="border" class="bordered_1px"></div>');
                $('#error').hide();

            }

        }).catch(function(error) {
            console.log(error);
        });

    });
    //end

    //start filer ville
    document.querySelector('.chatAjaxForm').addEventListener('submit', function(e) {
        e.preventDefault();
        axios.post($(".chatAjaxForm").attr('action'), { idResion: $('#region').val() }).then(function(response) {
            const villes = response.data.villes;
            const newName = [];
            for (var i = 0; i < villes.length; i++) {
                newName.push(villes[i]["name"]);
            }
            for (var i = 0; i < nameVilles.length; i++) {
                if (nameVilles.includes(nameVilles[i]) && newName.includes(nameVilles[i])) {
                    $('#' + nameVilles[i]).show();
                    console.log("show " + nameVilles[i]);
                } else {
                    $('#' + nameVilles[i]).hide();
                    console.log("hide " + nameVilles[i]);
                }
            }

        }).catch(function(error) {
            console.log(error);
        });

    });
    //end 

})();