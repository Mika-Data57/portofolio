// jQuery code pour modifier la couleur des bordures
$(document).ready(function() {
    $(".card").hover(
      function() {
        $(this).addClass("border-orange"); // Ajout de la class orange
      },
      function() {
        $(this).removeClass("border-orange"); // Suppression de la class orange
      }
    );

    //Chargement Ajax des données MySQL
    $.ajax({
      url: './server/data.php',
      dataType: 'json',
      success: function(data) {
        // Générer les cartes pour chaque enregistrement
        moment.locale('fr');
        var cardsContainer = $("#cards-container");

        data.forEach(function(item) {
            // Formater la date en utilisant Moment.js
            var formattedDate = moment(item.created_date).format("[Posté le] DD MMMM YYYY [à] HH[h]mm");
            var cardHtml = `
                <div class="col-md-4 mb-4">
                    <div class="card h-100 m-2">
                        <img src="${item.ref_img}" class="card-img-top" alt="${item.title}" style="object-fit: cover; height:200px;">
                        <div class="card-body">
                            <h5 class="card-title first-title">${item.title}</h5>
                            <p class="card-text">${item.description}</p>
                            <span class="small">${formattedDate}</span>
                        </div>
                        <div class="card-footer">
                            <a href="./detail.html?id=${item.card_id}" class="btn btn-primary">Voir le détail</a>
                            <a href="./server/delete.php?id=${item.card_id}&img=${encodeURIComponent(item.ref_img)}" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            `;

            cardsContainer.append(cardHtml);
        });
    },
      error: function(xhr, status, error) {
          console.error("Erreur AJAX : " + error);
      }
    });

    //Fonction Carousel
    $('.carousel').carousel({
      interval: 8000
    });

    //Envoi du formulaire add-card
    $("#FormSendTravel").submit(function(event) {
      event.preventDefault();
      var formData = new FormData(this);
      $.ajax({
        url: './server/upload.php',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(message) {
          message = '<p><h3>Un message pour vous !</h3><em style="font-size=12px !important">' + message + '</em></p>';
          $('#returnMessage').html(message);
          $('#message-modal').modal('show');
        },
        error: function(xhr, status, error){
          console.error("Erreur AJAX : " + error);
        }
      });
    });

    // Ajout de l'événement de clic pour la redirection
    $('#message-modal').on('hidden.bs.modal', function () {
      window.location.href = 'index.html';
    });
});

//Fonction pour charger le détail des cartes dynamiquement
function load_detail(cardId){
  $.ajax({
      type: 'POST',
      url: 'server/detail.php',
      data: {"card_id": cardId},
      dataType: 'json',
      success: function(detail) {
          //Alimentation des blocs de thumbnail
          $("#desc_title").html("Mon voyage à "+detail.thumbnail.title);
          $("#card_h5").html("Welcome to  "+detail.thumbnail.title);
          $("#detail_desc").html(detail.thumbnail.description);
          var formatedDate = moment(detail.thumbnail.created_date).format("[Posté le] DD MMMM YYYY [à] HH[h]mm");
          $("#detail_date").html(formatedDate);
          
          //Alimentation des images
          $.each(detail.carousel, function(index, img) {
            if(index === 0){
              $("#img_carousel").append('<div class="carousel-item active"><img class="d-block w-100" src="./assets/img/'+img.img_url+'"></div>');
            }
            else{
              $("#img_carousel").append('<div class="carousel-item"><img class="d-block w-100" src="./assets/img/'+img.img_url+'"></div>');
            }
          });
      },
      error: function(xhr, status, error) {
          console.error("Erreur AJAX : " + error);
      }
  });
}



