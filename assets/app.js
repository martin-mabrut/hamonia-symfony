import './stimulus_bootstrap.js';
import './styles/app.css';

const bouton = document.getElementById("bouton");
async function toggleFavorite() {

    const id = bouton.dataset.trackId;
    const url = `/toggle-favorite/${id}`;
    try {
        const reponse = await fetch(url);
        if (!reponse.ok) {
            throw new Error(`Statut de réponse : ${reponse.status}`);
        }

        const resultat = await reponse.json();
        console.log(resultat);
        return resultat;

        } catch (erreur) {
            console.error(erreur.message);
        }
    }


if(bouton) {
bouton.addEventListener("click", (e) => {
    toggleFavorite()
});
}
