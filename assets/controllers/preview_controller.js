import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

  constructor(context) {
    super(context);
    this.title = document.querySelector("[preview='form-publication-title']");
    this.description = document.querySelector("[preview='form-publication-description']");
  }

  connect() {
    this.title.addEventListener("input", this._onTitleInput);
    this.description.addEventListener("input", this._onDescriptionInput);
  }

  _onTitleInput(event) {
    let title = event.srcElement.value;
    if(!title){
      title = "Donnez un titre court et descriptif à votre code promo";
    }
    const preview = document.querySelector("#preview");
    const previewTitle = preview.querySelector("#preview-title");
    previewTitle.innerHTML = title;
  }

  _onDescriptionInput(event) {
    let description = event.srcElement.value;
    if(!description){
      description = "En manque d'idée ? Préseentez le produit ou l'offre avec vos propres mots, expliquez en quoi l'offre est intéressante selon vous.";
    }
    const preview = document.querySelector("#preview");
    const previewDescription = preview.querySelector("#preview-description");
    previewDescription.innerHTML = description;
  }
}
