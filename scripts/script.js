
function ajouterSport(){
    const sport = document.querySelector('[name="ajout_sport"]').value;
    window.location.href = sport ? "ajout.php?ajout_sport=" + sport : 'ajout.php';
}
