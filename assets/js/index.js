// Importing jQuery
// Import scripts to apply on project
import "./../scss/style.scss";

document.addEventListener("DOMContentLoaded", function () {
  const searchForm = document.querySelector(".search-form");
  const searchInput = searchForm.querySelector('input[name="q"]');

  let timeoutId;

  // Implementa debounce na busca
  searchInput.addEventListener("input", function () {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
      searchForm.submit();
    }, 500); // Aguarda 500ms após o usuário parar de digitar
  });
});

// Tornando a função moreInfo globalmente acessível
window.moreInfo = function (event) {
  event.preventDefault();
  const moreInfoButton =
    event.target.parentElement.parentElement.querySelector(".card-points");

  const moreInfoText = event.target.parentElement.parentElement.querySelectorAll(".card-more-info p");
  console.log(moreInfoText);
  
  if (moreInfoButton.style.height === "auto") {
    moreInfoButton.style.height = "85px";
    event.target.innerHTML = "More Info";
    moreInfoText[0].classList.add("d-block");
    moreInfoText[0].classList.remove("d-none");
    moreInfoText[1].classList.remove("d-block");
    moreInfoText[1].classList.add("d-none");

  } else {
    moreInfoButton.style.height = "auto";
    event.target.innerHTML = "Less Info";
    moreInfoText[0].classList.remove("d-block");
    moreInfoText[0].classList.add("d-none");
    moreInfoText[1].classList.add("d-block");
    moreInfoText[1].classList.remove("d-none");
  }
  
};

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.favoritar-gato').forEach(button => {
        button.addEventListener('click', async function() {
            const imageId = this.dataset.imageId;
            const favoriteId = this.dataset.favoriteId;
            
            if (this.classList.contains('favoritado')) {
                const response = await fetch('/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'remover_favorito',
                        favorite_id: favoriteId
                    })
                });

                const data = await response.json();
                if (data.success) {
                    this.classList.remove('favoritado');
                    this.dataset.favoriteId = '';
                    
                    // Verifica se está na página de favoritos e remove o card do gato
                    if (window.location.pathname === '/favoritos/') {
                      console.log(this)
                        const catCard = this.parentElement.parentElement.parentElement;
                        if (catCard) {
                            catCard.remove();
                        }
                    }
                }
            } else {
                // Tenta adicionar aos favoritos
                const response = await fetch('/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'adicionar_favorito',
                        image_id: imageId
                    })
                });

                const data = await response.json();
                if (data.success) {
                    this.classList.add('favoritado');
                    this.dataset.favoriteId = data.data.id;
                }
            }
        });
    });
});